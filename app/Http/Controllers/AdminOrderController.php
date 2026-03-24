<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $statusOptions = ['pending', 'paid', 'packing', 'shipped', 'completed', 'cancelled'];

        $filters = [
            'keyword' => trim((string) $request->input('keyword')),
            'status' => $request->input('status'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'amount_min' => $request->input('amount_min'),
            'amount_max' => $request->input('amount_max'),
        ];

        $ordersQuery = Order::query()
            ->when($filters['keyword'], function ($query, $keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('order_no', 'like', "%{$keyword}%")
                        ->orWhere('contact_name', 'like', "%{$keyword}%")
                        ->orWhere('contact_phone', 'like', "%{$keyword}%");
                });
            })
            ->when($filters['status'] && in_array($filters['status'], $statusOptions, true), function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when($filters['date_from'], function ($query, $dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($filters['date_to'], function ($query, $dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($filters['amount_min'] !== null && $filters['amount_min'] !== '', function ($query) use ($filters) {
                $query->where('total_amount', '>=', (float) $filters['amount_min']);
            })
            ->when($filters['amount_max'] !== null && $filters['amount_max'] !== '', function ($query) use ($filters) {
                $query->where('total_amount', '<=', (float) $filters['amount_max']);
            });

        $orders = $ordersQuery->latest()->paginate(15)->appends($request->query());

        return view('admin.orders', [
            'orders' => $orders,
            'filters' => $filters,
            'statusOptions' => $statusOptions,
        ]);
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
