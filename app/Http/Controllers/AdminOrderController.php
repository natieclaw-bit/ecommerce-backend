<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::latest()->get();

        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,paid,packing,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);
        $order->statusLogs()->create([
            'status' => $data['status'],
            'note' => '後台更新訂單狀態',
        ]);

        return redirect('/admin/orders')->with('success', '訂單狀態已更新');
    }
}
