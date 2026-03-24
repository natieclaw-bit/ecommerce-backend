<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'products' => Product::count(),
            'low_stock' => Product::whereHas('inventory', fn ($query) => $query->where('quantity', '<=', 10))->count(),
            'orders_today' => Order::whereDate('created_at', now()->toDateString())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with(['items', 'statusLogs'])
            ->latest()
            ->limit(5)
            ->get();

        $lowStockProducts = Product::with('inventory')
            ->whereHas('inventory', fn ($query) => $query->where('quantity', '<=', 10))
            ->orderByRaw('(select quantity from inventories where inventories.product_id = products.id) asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }

    public function orders()
    {
        $orders = Order::latest()->get();

        return view('admin.orders', compact('orders'));
    }
}
