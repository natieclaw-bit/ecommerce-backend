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

        return view('admin.dashboard', compact('stats'));
    }

    public function orders()
    {
        $orders = Order::latest()->get();

        return view('admin.orders', compact('orders'));
    }
}
