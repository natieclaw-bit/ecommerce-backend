<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function cart()
    {
        $cartItems = [
            [
                'name' => '經典咖啡豆',
                'sku' => 'CF-001',
                'price' => 320,
                'quantity' => 2,
                'image' => 'https://images.unsplash.com/photo-1507133750040-4a8f57021571?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name' => '濾掛咖啡組',
                'sku' => 'DG-002',
                'price' => 180,
                'quantity' => 1,
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=600&q=80',
            ],
        ];

        $summary = [
            'shipping' => 120,
            'discount' => 0,
        ];

        $summary['subtotal'] = collect($cartItems)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $summary['total'] = $summary['subtotal'] + $summary['shipping'] - $summary['discount'];

        return view('cart.index', compact('cartItems', 'summary'));
    }

    public function checkout()
    {
        $orderPreview = [
            'items' => [
                ['name' => '經典咖啡豆', 'quantity' => 2, 'price' => 320],
                ['name' => '濾掛咖啡組', 'quantity' => 1, 'price' => 180],
            ],
            'shipping_methods' => ['黑貓宅急便', '7-11 取貨', '全家取貨'],
            'payment_methods' => ['信用卡', 'Line Pay', '貨到付款'],
        ];

        $orderPreview['subtotal'] = collect($orderPreview['items'])->sum(fn ($item) => $item['price'] * $item['quantity']);
        $orderPreview['shipping'] = 120;
        $orderPreview['total'] = $orderPreview['subtotal'] + $orderPreview['shipping'];

        return view('checkout.index', compact('orderPreview'));
    }

    public function tracking()
    {
        $order = Order::with(['statusLogs' => function ($query) {
            $query->orderBy('created_at');
        }])->latest()->first();

        if (!$order) {
            $timeline = [
                ['status' => 'pending', 'label' => '訂單建立', 'timestamp' => now()->subHours(3)],
                ['status' => 'paid', 'label' => '付款完成', 'timestamp' => now()->subHours(2)],
                ['status' => 'packing', 'label' => '備貨中', 'timestamp' => now()->subHour()],
            ];
            $orderNumber = 'ORD-LOCAL-0001';
        } else {
            $timeline = $order->statusLogs->map(function ($log) {
                return [
                    'status' => $log->status,
                    'label' => $log->note ?? ucfirst($log->status),
                    'timestamp' => $log->created_at,
                ];
            })->toArray();
            $orderNumber = $order->order_no;
        }

        return view('orders.tracking', [
            'timeline' => $timeline,
            'orderNumber' => $orderNumber,
        ]);
    }
}
