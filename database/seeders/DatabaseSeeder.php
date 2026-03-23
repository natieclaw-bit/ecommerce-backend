<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@stockflow.test'],
            ['name' => 'Admin', 'password' => 'password', 'role' => 'admin']
        );

        $customer = User::updateOrCreate(
            ['email' => 'customer@stockflow.test'],
            ['name' => 'Customer', 'password' => 'password', 'role' => 'customer']
        );

        $products = collect([
            ['sku' => 'CF-001', 'name' => '經典咖啡豆', 'price' => 320, 'quantity' => 48],
            ['sku' => 'DG-002', 'name' => '濾掛咖啡組', 'price' => 180, 'quantity' => 120],
            ['sku' => 'BT-003', 'name' => '冷萃玻璃瓶', 'price' => 450, 'quantity' => 12],
        ])->map(function ($item) {
            $product = Product::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name'] . '-' . $item['sku']),
                    'description' => $item['name'] . ' 商品介紹待補。',
                    'price' => $item['price'],
                    'status' => 'active',
                ]
            );

            Inventory::updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $item['quantity'], 'reserved_quantity' => 0]
            );

            return $product;
        });

        $order = Order::updateOrCreate(
            ['order_no' => 'ORD-20260323-001'],
            [
                'user_id' => $customer->id,
                'status' => 'pending',
                'total_amount' => 640,
                'contact_name' => '王小明',
                'contact_phone' => '0912345678',
                'shipping_address' => '台北市信義區示範路 1 號',
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order->id, 'product_name' => '經典咖啡豆'],
            [
                'product_id' => $products[0]->id,
                'unit_price' => 320,
                'quantity' => 2,
                'subtotal' => 640,
            ]
        );

        OrderStatusLog::updateOrCreate(
            ['order_id' => $order->id, 'status' => 'pending'],
            ['note' => '訂單建立']
        );
    }
}
