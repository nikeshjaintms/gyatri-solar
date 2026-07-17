<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Enquiry;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of quotations.
     */
    public function index(Request $request)
    {
        $query = Quotation::with('customer');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_number', 'like', '%' . $search . '%')
                  ->orWhereHas('customer', function ($sub) use ($search) {
                      $sub->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date filter range
        if ($request->filled('from_date')) {
            $query->whereDate('quotation_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('quotation_date', '<=', $request->to_date);
        }

        $quotations = $query->latest('id')->paginate(10)->withQueryString();

        return view('admin.quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new quotation.
     */
    public function create()
    {
        $enquiries = Enquiry::whereNotIn('status', ['Closed', 'Cancelled'])->orderBy('enquiry_number', 'desc')->get();
        $customers = Customer::orderBy('name')->get();
        $products = \App\Models\Product::where('status', 'Active')->orderBy('name')->get();

        // Auto-generate unique Quotation Number
        $latest = Quotation::latest('id')->first();
        $nextId = $latest ? ($latest->id + 1) : 1;
        $quotationNumber = 'QT-' . date('Ym') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('admin.quotations.create', compact('enquiries', 'customers', 'quotationNumber', 'products'));
    }

    /**
     * Store a newly created quotation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quotation_number' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-\_]+$/', 'unique:quotations,quotation_number'],
            'enquiry_id' => ['nullable', 'exists:enquiries,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'quotation_date' => ['required', 'date'],
            'valid_until' => ['required', 'date', 'after_or_equal:quotation_date'],
            'terms_conditions' => ['nullable', 'string', 'max:5000'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:Draft,Sent,Accepted,Rejected,Expired,Cancelled'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'items.*.tax_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'items.*.description' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            $totalDiscount = 0;
            $totalTax = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $prod = \App\Models\Product::find($item['product_id']);
                $amount = $item['quantity'] * $item['unit_price'];
                $discountAmount = $amount * ($item['discount_percentage'] / 100);
                $taxable = max(0, $amount - $discountAmount);
                $taxAmount = $taxable * ($item['tax_percentage'] / 100);
                $lineTotal = $taxable + $taxAmount;

                $subtotal += $amount;
                $totalDiscount += $discountAmount;
                $totalTax += $taxAmount;

                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'product_service' => $prod->name,
                    'description' => isset($item['description']) ? trim(strip_tags($item['description'])) : null,
                    'quantity' => $item['quantity'],
                    'unit' => $prod->unit,
                    'unit_price' => $item['unit_price'],
                    'discount_percentage' => $item['discount_percentage'],
                    'tax_percentage' => $item['tax_percentage'],
                    'tax_amount' => $taxAmount,
                    'subtotal' => $lineTotal,
                ];
            }

            $grandTotal = $subtotal - $totalDiscount + $totalTax;

            $quotation = Quotation::create([
                'quotation_number' => trim(strip_tags($request->quotation_number)),
                'enquiry_id' => $request->enquiry_id,
                'customer_id' => $request->customer_id,
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'subtotal' => $subtotal,
                'tax_percentage' => $subtotal > 0 ? (($totalTax / ($subtotal - $totalDiscount)) * 100) : 0,
                'tax_amount' => $totalTax,
                'discount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'terms_conditions' => trim(strip_tags($request->terms_conditions)),
                'notes' => trim(strip_tags($request->notes)),
                'status' => $request->status,
            ]);

            foreach ($itemsData as $itemData) {
                $quotation->items()->create($itemData);
            }
        });

        return redirect()->route('quotations.index')->with('success', 'Quotation created successfully.');
    }

    /**
     * Display the specified quotation.
     */
    public function show(string $id)
    {
        $quotation = Quotation::with(['customer', 'enquiry', 'items.product'])->findOrFail($id);
        return view('admin.quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified quotation.
     */
    public function edit(string $id)
    {
        $quotation = Quotation::with('items.product')->findOrFail($id);
        $enquiries = Enquiry::orderBy('enquiry_number', 'desc')->get();
        $customers = Customer::orderBy('name')->get();
        $products = \App\Models\Product::where('status', 'Active')->orderBy('name')->get();

        return view('admin.quotations.edit', compact('quotation', 'enquiries', 'customers', 'products'));
    }

    /**
     * Update the specified quotation in storage.
     */
    public function update(Request $request, string $id)
    {
        $quotation = Quotation::findOrFail($id);

        $validated = $request->validate([
            'quotation_number' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-\_]+$/', Rule::unique('quotations', 'quotation_number')->ignore($quotation->id)],
            'enquiry_id' => ['nullable', 'exists:enquiries,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'quotation_date' => ['required', 'date'],
            'valid_until' => ['required', 'date', 'after_or_equal:quotation_date'],
            'terms_conditions' => ['nullable', 'string', 'max:5000'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:Draft,Sent,Accepted,Rejected,Expired,Cancelled'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'items.*.tax_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'items.*.description' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($request, $quotation) {
            // Delete old items
            $quotation->items()->delete();

            $subtotal = 0;
            $totalDiscount = 0;
            $totalTax = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $prod = \App\Models\Product::find($item['product_id']);
                $amount = $item['quantity'] * $item['unit_price'];
                $discountAmount = $amount * ($item['discount_percentage'] / 100);
                $taxable = max(0, $amount - $discountAmount);
                $taxAmount = $taxable * ($item['tax_percentage'] / 100);
                $lineTotal = $taxable + $taxAmount;

                $subtotal += $amount;
                $totalDiscount += $discountAmount;
                $totalTax += $taxAmount;

                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'product_service' => $prod->name,
                    'description' => isset($item['description']) ? trim(strip_tags($item['description'])) : null,
                    'quantity' => $item['quantity'],
                    'unit' => $prod->unit,
                    'unit_price' => $item['unit_price'],
                    'discount_percentage' => $item['discount_percentage'],
                    'tax_percentage' => $item['tax_percentage'],
                    'tax_amount' => $taxAmount,
                    'subtotal' => $lineTotal,
                ];
            }

            $grandTotal = $subtotal - $totalDiscount + $totalTax;

            $quotation->update([
                'quotation_number' => trim(strip_tags($request->quotation_number)),
                'enquiry_id' => $request->enquiry_id,
                'customer_id' => $request->customer_id,
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'subtotal' => $subtotal,
                'tax_percentage' => $subtotal > 0 ? (($totalTax / ($subtotal - $totalDiscount)) * 100) : 0,
                'tax_amount' => $totalTax,
                'discount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'terms_conditions' => trim(strip_tags($request->terms_conditions)),
                'notes' => trim(strip_tags($request->notes)),
                'status' => $request->status,
            ]);

            foreach ($itemsData as $itemData) {
                $quotation->items()->create($itemData);
            }
        });

        return redirect()->route('quotations.index')->with('success', 'Quotation updated successfully.');
    }

    /**
     * Print the quotation.
     */
    public function print(string $id)
    {
        $quotation = Quotation::with(['customer', 'items', 'enquiry'])->findOrFail($id);
        return view('admin.quotations.print', compact('quotation'));
    }

    /**
     * Remove the specified quotation.
     */
    public function destroy(string $id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();

        return redirect()->route('quotations.index')->with('success', 'Quotation deleted successfully.');
    }
}
