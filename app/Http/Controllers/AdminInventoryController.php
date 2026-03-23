<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminInventoryController extends Controller
{
    public function index(): View
    {
        $inventories = Inventory::with('product')->latest()->get();

        return view('admin.inventory', compact('inventories'));
    }

    public function edit(Inventory $inventory): View
    {
        $inventory->load('product');

        return view('admin.inventory-form', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
            'reserved_quantity' => ['required', 'integer', 'min:0'],
        ]);

        $inventory->update($data);

        return redirect('/admin/inventory')->with('success', '庫存已更新');
    }
}
