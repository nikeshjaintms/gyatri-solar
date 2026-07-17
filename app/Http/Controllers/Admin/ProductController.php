<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search Product
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_code', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%')
                  ->orWhere('model_number', 'like', '%' . $search . '%');
            });
        }

        // Filter Product Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter Product Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        // Get unique categories for dropdown filter
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextProductCode = $this->generateProductCode();
        return view('admin.products.create', compact('nextProductCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'category' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model_number' => ['nullable', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'hsn_sac_code' => ['nullable', 'string', 'max:50'],
            'gst' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'opening_stock' => ['nullable', 'integer', 'min:0'],
            'minimum_stock_level' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        $data = $request->except('image');
        $data['name'] = trim(strip_tags($request->name));
        $data['category'] = trim(strip_tags($request->category));
        if ($request->filled('brand')) $data['brand'] = trim(strip_tags($request->brand));
        if ($request->filled('model_number')) $data['model_number'] = trim(strip_tags($request->model_number));
        $data['unit'] = trim(strip_tags($request->unit));
        if ($request->filled('hsn_sac_code')) $data['hsn_sac_code'] = trim(strip_tags($request->hsn_sac_code));
        if ($request->filled('description')) $data['description'] = trim(strip_tags($request->description));
        
        $data['product_code'] = $this->generateProductCode();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'category' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model_number' => ['nullable', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'hsn_sac_code' => ['nullable', 'string', 'max:50'],
            'gst' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'opening_stock' => ['nullable', 'integer', 'min:0'],
            'minimum_stock_level' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        $data = $request->except('image');
        $data['name'] = trim(strip_tags($request->name));
        $data['category'] = trim(strip_tags($request->category));
        if ($request->filled('brand')) $data['brand'] = trim(strip_tags($request->brand));
        if ($request->filled('model_number')) $data['model_number'] = trim(strip_tags($request->model_number));
        $data['unit'] = trim(strip_tags($request->unit));
        if ($request->filled('hsn_sac_code')) $data['hsn_sac_code'] = trim(strip_tags($request->hsn_sac_code));
        if ($request->filled('description')) $data['description'] = trim(strip_tags($request->description));

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Prevent delete if linked with Quotation items
        if (\App\Models\QuotationItem::where('product_id', $product->id)->exists()) {
            return redirect()->route('products.index')->with('error', 'Cannot delete product because it is linked to quotations.');
        }

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Generate the next Product Code (e.g. PROD0001)
     */
    private function generateProductCode()
    {
        $latest = Product::orderBy('id', 'desc')->first();
        if ($latest) {
            $number = intval(substr($latest->product_code, 4));
            return 'PROD' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        }
        return 'PROD0001';
    }
}
