<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('inventory')->latest()->get();

        return view('admin.products', compact('products'));
    }

    public function create(): View
    {
        return view('admin.product-form', [
            'product' => new Product(),
            'inventoryQty' => 0,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $product = Product::create([
            'sku' => $data['sku'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . $data['sku']),
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'status' => $data['status'],
        ]);

        Inventory::create([
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'reserved_quantity' => 0,
        ]);

        return redirect('/admin/products')->with('success', '商品已建立');
    }

    public function edit(Product $product): View
    {
        $product->load('inventory');

        return view('admin.product-form', [
            'product' => $product,
            'inventoryQty' => $product->inventory?->quantity ?? 0,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $product->update([
            'sku' => $data['sku'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . $data['sku']),
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'status' => $data['status'],
        ]);

        $product->inventory()->updateOrCreate(
            ['product_id' => $product->id],
            ['quantity' => $data['quantity']]
        );

        return redirect('/admin/products')->with('success', '商品已更新');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect('/admin/products')->with('success', '商品已刪除');
    }
}
