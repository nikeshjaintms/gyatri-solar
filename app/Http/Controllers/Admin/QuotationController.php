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
use Illuminate\Support\Facades\Storage;

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
        $quotation = new Quotation();

        // Auto-generate unique Quotation Number
        $latest = Quotation::latest('id')->first();
        $nextId = $latest ? ($latest->id + 1) : 1;
        $quotationNumber = 'QT-' . date('Ym') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('admin.quotations.create', compact('enquiries', 'customers', 'quotationNumber', 'products', 'quotation'));
    }

    public function store(Request $request)
    {
        $proposalRules = [
            'system_size' => ['nullable', 'string', 'max:255'],
            'created_by_name' => ['nullable', 'string', 'max:255'],
            'created_by_phone' => ['nullable', 'string', 'max:255'],
            'per_kw_rate' => ['nullable', 'string', 'max:255'],
            'rooftop_amount' => ['nullable', 'string', 'max:255'],
            'net_metering_cost' => ['nullable', 'string', 'max:255'],
            'mnre_subsidy' => ['nullable', 'string', 'max:255'],
            'final_effective_cost' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_no' => ['nullable', 'string', 'max:255'],
            'bank_ifsc' => ['nullable', 'string', 'max:255'],
            'bank_branch' => ['nullable', 'string', 'max:255'],
            'bank_gst_no' => ['nullable', 'string', 'max:255'],
            'panel_watt_peak' => ['nullable', 'string', 'max:255'],
            'panel_qty' => ['nullable', 'string', 'max:255'],
            'panel_type' => ['nullable', 'string', 'max:255'],
            'panel_make' => ['nullable', 'string', 'max:255'],
            'inverter_size' => ['nullable', 'string', 'max:255'],
            'inverter_qty' => ['nullable', 'string', 'max:255'],
            'inverter_make' => ['nullable', 'string', 'max:255'],
            'cable_ac' => ['nullable', 'string', 'max:255'],
            'cable_ac_qty' => ['nullable', 'string', 'max:255'],
            'cable_dc' => ['nullable', 'string', 'max:255'],
            'cable_dc_qty' => ['nullable', 'string', 'max:255'],
            'cable_earthing' => ['nullable', 'string', 'max:255'],
            'cable_earthing_qty' => ['nullable', 'string', 'max:255'],
            'cable_la' => ['nullable', 'string', 'max:255'],
            'cable_la_qty' => ['nullable', 'string', 'max:255'],
            'structure_height' => ['nullable', 'string', 'max:255'],
            'structure_material' => ['nullable', 'string', 'max:5000'],
            'bos_acdb' => ['nullable', 'string', 'max:5000'],
            'bos_dcdb' => ['nullable', 'string', 'max:5000'],
            'bos_earthing' => ['nullable', 'string', 'max:5000'],
            'bos_la' => ['nullable', 'string', 'max:5000'],
            'bos_misc' => ['nullable', 'string', 'max:5000'],
            'warranty_panel' => ['nullable', 'string', 'max:255'],
            'warranty_performance' => ['nullable', 'string', 'max:255'],
            'warranty_inverter' => ['nullable', 'string', 'max:255'],
            'warranty_system' => ['nullable', 'string', 'max:255'],
            'savings_payback' => ['nullable', 'string', 'max:255'],
            'savings_yearly_generation' => ['nullable', 'string', 'max:255'],
            'savings_annual_savings' => ['nullable', 'string', 'max:255'],
            'savings_project_cost' => ['nullable', 'string', 'max:255'],
            'savings_trees_saved' => ['nullable', 'string', 'max:255'],
            'savings_co2_reduction' => ['nullable', 'string', 'max:255'],
            'panel_open_circuit_voltage' => ['nullable', 'string', 'max:255'],
            'panel_max_voltage' => ['nullable', 'string', 'max:255'],
            'panel_short_circuit_current' => ['nullable', 'string', 'max:255'],
            'panel_max_current' => ['nullable', 'string', 'max:255'],
            'bos_protection_system' => ['nullable', 'string', 'max:1000'],
            'bos_lt_ht_panels' => ['nullable', 'string', 'max:1000'],
            'bos_metering' => ['nullable', 'string', 'max:1000'],
            'partner_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
            'signature_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
        ];

        $validated = $request->validate(array_merge([
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
            'items.*.unit' => ['nullable', 'string', 'max:50'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'items.*.tax_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'items.*.description' => ['nullable', 'string', 'max:1000'],
        ], $proposalRules));

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            $totalDiscount = 0;
            $totalTax = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $prod = \App\Models\Product::find($item['product_id']);
                $qty = floatval($item['quantity'] ?? 1);
                $unitPrice = floatval($item['unit_price'] ?? 0);
                $discountPct = isset($item['discount_percentage']) && $item['discount_percentage'] !== '' ? floatval($item['discount_percentage']) : 0;
                $taxPct = isset($item['tax_percentage']) && $item['tax_percentage'] !== '' ? floatval($item['tax_percentage']) : ($prod ? floatval($prod->gst) : 0);
                $unit = !empty($item['unit']) ? trim(strip_tags($item['unit'])) : ($prod ? $prod->unit : null);

                $amount = $qty * $unitPrice;
                $discountAmount = $amount * ($discountPct / 100);
                $taxable = max(0, $amount - $discountAmount);
                $taxAmount = $taxable * ($taxPct / 100);
                $lineTotal = $taxable + $taxAmount;

                $subtotal += $amount;
                $totalDiscount += $discountAmount;
                $totalTax += $taxAmount;

                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'product_service' => $prod ? $prod->name : 'Product',
                    'description' => isset($item['description']) ? trim(strip_tags($item['description'])) : null,
                    'quantity' => $qty,
                    'unit' => $unit,
                    'unit_price' => $unitPrice,
                    'discount_percentage' => $discountPct,
                    'tax_percentage' => $taxPct,
                    'tax_amount' => $taxAmount,
                    'subtotal' => $lineTotal,
                ];
            }

            $grandTotal = $subtotal - $totalDiscount + $totalTax;

            $proposalFields = [
                'system_size', 'created_by_name', 'created_by_phone',
                'per_kw_rate', 'rooftop_amount', 'net_metering_cost', 'mnre_subsidy', 'final_effective_cost',
                'bank_name', 'bank_account_name', 'bank_account_no', 'bank_ifsc', 'bank_branch', 'bank_gst_no',
                'panel_watt_peak', 'panel_qty', 'panel_type', 'panel_make',
                'inverter_size', 'inverter_qty', 'inverter_make',
                'cable_ac', 'cable_ac_qty', 'cable_dc', 'cable_dc_qty', 'cable_earthing', 'cable_earthing_qty', 'cable_la', 'cable_la_qty',
                'structure_height', 'structure_material',
                'bos_acdb', 'bos_dcdb', 'bos_earthing', 'bos_la', 'bos_misc',
                'warranty_panel', 'warranty_performance', 'warranty_inverter', 'warranty_system',
                'savings_payback', 'savings_yearly_generation', 'savings_annual_savings', 'savings_project_cost', 'savings_trees_saved', 'savings_co2_reduction',
                'panel_open_circuit_voltage', 'panel_max_voltage', 'panel_short_circuit_current', 'panel_max_current',
                'bos_protection_system', 'bos_lt_ht_panels', 'bos_metering'
            ];

            $taxableSubtotal = max(0, $subtotal - $totalDiscount);
            $quotationData = [
                'quotation_number' => trim(strip_tags($request->quotation_number)),
                'enquiry_id' => $request->enquiry_id,
                'customer_id' => $request->customer_id,
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'subtotal' => $subtotal,
                'tax_percentage' => $taxableSubtotal > 0 ? (($totalTax / $taxableSubtotal) * 100) : 0,
                'tax_amount' => $totalTax,
                'discount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'terms_conditions' => trim(strip_tags($request->terms_conditions)),
                'notes' => trim(strip_tags($request->notes)),
                'status' => $request->status,
            ];

            foreach ($proposalFields as $field) {
                if ($request->has($field)) {
                    $quotationData[$field] = $request->input($field);
                }
            }

            if ($request->hasFile('partner_logo')) {
                $quotationData['partner_logo'] = $request->file('partner_logo')->store('quotations/logos', 'public');
            }

            if ($request->hasFile('signature_image')) {
                $quotationData['signature_image'] = $request->file('signature_image')->store('quotations/signatures', 'public');
            }

            $quotation = Quotation::create($quotationData);

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

    public function update(Request $request, string $id)
    {
        $quotation = Quotation::findOrFail($id);
        $proposalRules = [
            'system_size' => ['nullable', 'string', 'max:255'],
            'created_by_name' => ['nullable', 'string', 'max:255'],
            'created_by_phone' => ['nullable', 'string', 'max:255'],
            'per_kw_rate' => ['nullable', 'string', 'max:255'],
            'rooftop_amount' => ['nullable', 'string', 'max:255'],
            'net_metering_cost' => ['nullable', 'string', 'max:255'],
            'mnre_subsidy' => ['nullable', 'string', 'max:255'],
            'final_effective_cost' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_no' => ['nullable', 'string', 'max:255'],
            'bank_ifsc' => ['nullable', 'string', 'max:255'],
            'bank_branch' => ['nullable', 'string', 'max:255'],
            'bank_gst_no' => ['nullable', 'string', 'max:255'],
            'panel_watt_peak' => ['nullable', 'string', 'max:255'],
            'panel_qty' => ['nullable', 'string', 'max:255'],
            'panel_type' => ['nullable', 'string', 'max:255'],
            'panel_make' => ['nullable', 'string', 'max:255'],
            'inverter_size' => ['nullable', 'string', 'max:255'],
            'inverter_qty' => ['nullable', 'string', 'max:255'],
            'inverter_make' => ['nullable', 'string', 'max:255'],
            'cable_ac' => ['nullable', 'string', 'max:255'],
            'cable_ac_qty' => ['nullable', 'string', 'max:255'],
            'cable_dc' => ['nullable', 'string', 'max:255'],
            'cable_dc_qty' => ['nullable', 'string', 'max:255'],
            'cable_earthing' => ['nullable', 'string', 'max:255'],
            'cable_earthing_qty' => ['nullable', 'string', 'max:255'],
            'cable_la' => ['nullable', 'string', 'max:255'],
            'cable_la_qty' => ['nullable', 'string', 'max:255'],
            'structure_height' => ['nullable', 'string', 'max:255'],
            'structure_material' => ['nullable', 'string', 'max:5000'],
            'bos_acdb' => ['nullable', 'string', 'max:5000'],
            'bos_dcdb' => ['nullable', 'string', 'max:5000'],
            'bos_earthing' => ['nullable', 'string', 'max:5000'],
            'bos_la' => ['nullable', 'string', 'max:5000'],
            'bos_misc' => ['nullable', 'string', 'max:5000'],
            'warranty_panel' => ['nullable', 'string', 'max:255'],
            'warranty_performance' => ['nullable', 'string', 'max:255'],
            'warranty_inverter' => ['nullable', 'string', 'max:255'],
            'warranty_system' => ['nullable', 'string', 'max:255'],
            'savings_payback' => ['nullable', 'string', 'max:255'],
            'savings_yearly_generation' => ['nullable', 'string', 'max:255'],
            'savings_annual_savings' => ['nullable', 'string', 'max:255'],
            'savings_project_cost' => ['nullable', 'string', 'max:255'],
            'savings_trees_saved' => ['nullable', 'string', 'max:255'],
            'savings_co2_reduction' => ['nullable', 'string', 'max:255'],
            'panel_open_circuit_voltage' => ['nullable', 'string', 'max:255'],
            'panel_max_voltage' => ['nullable', 'string', 'max:255'],
            'panel_short_circuit_current' => ['nullable', 'string', 'max:255'],
            'panel_max_current' => ['nullable', 'string', 'max:255'],
            'bos_protection_system' => ['nullable', 'string', 'max:1000'],
            'bos_lt_ht_panels' => ['nullable', 'string', 'max:1000'],
            'bos_metering' => ['nullable', 'string', 'max:1000'],
            'partner_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
            'signature_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
        ];

        $validated = $request->validate(array_merge([
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
            'items.*.unit' => ['nullable', 'string', 'max:50'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'items.*.tax_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'items.*.description' => ['nullable', 'string', 'max:1000'],
        ], $proposalRules));

        DB::transaction(function () use ($request, $quotation) {
            // Delete old items
            $quotation->items()->delete();

            $subtotal = 0;
            $totalDiscount = 0;
            $totalTax = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $prod = \App\Models\Product::find($item['product_id']);
                $qty = floatval($item['quantity'] ?? 1);
                $unitPrice = floatval($item['unit_price'] ?? 0);
                $discountPct = isset($item['discount_percentage']) && $item['discount_percentage'] !== '' ? floatval($item['discount_percentage']) : 0;
                $taxPct = isset($item['tax_percentage']) && $item['tax_percentage'] !== '' ? floatval($item['tax_percentage']) : ($prod ? floatval($prod->gst) : 0);
                $unit = !empty($item['unit']) ? trim(strip_tags($item['unit'])) : ($prod ? $prod->unit : null);

                $amount = $qty * $unitPrice;
                $discountAmount = $amount * ($discountPct / 100);
                $taxable = max(0, $amount - $discountAmount);
                $taxAmount = $taxable * ($taxPct / 100);
                $lineTotal = $taxable + $taxAmount;

                $subtotal += $amount;
                $totalDiscount += $discountAmount;
                $totalTax += $taxAmount;

                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'product_service' => $prod ? $prod->name : 'Product',
                    'description' => isset($item['description']) ? trim(strip_tags($item['description'])) : null,
                    'quantity' => $qty,
                    'unit' => $unit,
                    'unit_price' => $unitPrice,
                    'discount_percentage' => $discountPct,
                    'tax_percentage' => $taxPct,
                    'tax_amount' => $taxAmount,
                    'subtotal' => $lineTotal,
                ];
            }

            $grandTotal = $subtotal - $totalDiscount + $totalTax;

            $proposalFields = [
                'system_size', 'created_by_name', 'created_by_phone',
                'per_kw_rate', 'rooftop_amount', 'net_metering_cost', 'mnre_subsidy', 'final_effective_cost',
                'bank_name', 'bank_account_name', 'bank_account_no', 'bank_ifsc', 'bank_branch', 'bank_gst_no',
                'panel_watt_peak', 'panel_qty', 'panel_type', 'panel_make',
                'inverter_size', 'inverter_qty', 'inverter_make',
                'cable_ac', 'cable_ac_qty', 'cable_dc', 'cable_dc_qty', 'cable_earthing', 'cable_earthing_qty', 'cable_la', 'cable_la_qty',
                'structure_height', 'structure_material',
                'bos_acdb', 'bos_dcdb', 'bos_earthing', 'bos_la', 'bos_misc',
                'warranty_panel', 'warranty_performance', 'warranty_inverter', 'warranty_system',
                'savings_payback', 'savings_yearly_generation', 'savings_annual_savings', 'savings_project_cost', 'savings_trees_saved', 'savings_co2_reduction',
                'panel_open_circuit_voltage', 'panel_max_voltage', 'panel_short_circuit_current', 'panel_max_current',
                'bos_protection_system', 'bos_lt_ht_panels', 'bos_metering'
            ];

            $taxableSubtotal = max(0, $subtotal - $totalDiscount);
            $updateData = [
                'quotation_number' => trim(strip_tags($request->quotation_number)),
                'enquiry_id' => $request->enquiry_id,
                'customer_id' => $request->customer_id,
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'subtotal' => $subtotal,
                'tax_percentage' => $taxableSubtotal > 0 ? (($totalTax / $taxableSubtotal) * 100) : 0,
                'tax_amount' => $totalTax,
                'discount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'terms_conditions' => trim(strip_tags($request->terms_conditions)),
                'notes' => trim(strip_tags($request->notes)),
                'status' => $request->status,
            ];

            foreach ($proposalFields as $field) {
                if ($request->has($field)) {
                    $updateData[$field] = $request->input($field);
                }
            }

            if ($request->hasFile('partner_logo')) {
                if ($quotation->partner_logo && Storage::disk('public')->exists($quotation->partner_logo)) {
                    Storage::disk('public')->delete($quotation->partner_logo);
                }
                $updateData['partner_logo'] = $request->file('partner_logo')->store('quotations/logos', 'public');
            } elseif ($request->boolean('remove_partner_logo')) {
                if ($quotation->partner_logo && Storage::disk('public')->exists($quotation->partner_logo)) {
                    Storage::disk('public')->delete($quotation->partner_logo);
                }
                $updateData['partner_logo'] = null;
            }

            if ($request->hasFile('signature_image')) {
                if ($quotation->signature_image && Storage::disk('public')->exists($quotation->signature_image)) {
                    Storage::disk('public')->delete($quotation->signature_image);
                }
                $updateData['signature_image'] = $request->file('signature_image')->store('quotations/signatures', 'public');
            } elseif ($request->boolean('remove_signature_image')) {
                if ($quotation->signature_image && Storage::disk('public')->exists($quotation->signature_image)) {
                    Storage::disk('public')->delete($quotation->signature_image);
                }
                $updateData['signature_image'] = null;
            }

            $quotation->update($updateData);

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
