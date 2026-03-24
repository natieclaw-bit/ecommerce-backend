<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Product;
use App\Models\ProductVariant;
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

        $categoryTree = [
            '咖啡豆' => ['精品咖啡豆', '濾掛咖啡'],
            '咖啡器具' => ['冷萃設備'],
        ];

        $categoryMap = collect();
        foreach ($categoryTree as $parentName => $children) {
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($parentName)],
                ['name' => $parentName, 'description' => $parentName . ' 相關商品']
            );
            $categoryMap[$parentName] = $parent;

            foreach ($children as $childName) {
                $child = Category::updateOrCreate(
                    ['slug' => Str::slug($parentName . '-' . $childName)],
                    ['name' => $childName, 'parent_id' => $parent->id]
                );
                $categoryMap[$childName] = $child;
            }
        }

        $products = collect([
            [
                'sku' => 'CF-001',
                'name' => '經典咖啡豆',
                'price' => 320,
                'quantity' => 48,
                'image' => 'https://images.unsplash.com/photo-1507133750040-4a8f57021571?auto=format&fit=crop&w=800&q=80',
                'categories' => ['精品咖啡豆'],
                'variant_attributes' => ['焙度' => '中深焙', '重量' => '250g'],
            ],
            [
                'sku' => 'DG-002',
                'name' => '濾掛咖啡組',
                'price' => 180,
                'quantity' => 120,
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80',
                'categories' => ['濾掛咖啡'],
                'variant_attributes' => ['口味' => '經典綜合', '入數' => '10 入'],
            ],
            [
                'sku' => 'BT-003',
                'name' => '冷萃玻璃瓶',
                'price' => 450,
                'quantity' => 12,
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=80',
                'categories' => ['冷萃設備'],
                'variant_attributes' => ['容量' => '600ml', '顏色' => '透明'],
            ],
        ])->map(function ($item) use ($categoryMap) {
            $product = Product::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name'] . '-' . $item['sku']),
                    'description' => $item['name'] . ' 商品介紹待補。',
                    'image_url' => $item['image'],
                    'price' => $item['price'],
                    'status' => 'active',
                ]
            );

            if (! empty($item['categories'])) {
                $categoryIds = collect($item['categories'])
                    ->map(fn ($name) => optional($categoryMap[$name] ?? null)->id)
                    ->filter()
                    ->all();
                $product->categories()->sync($categoryIds);
            }

            Inventory::updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $item['quantity'], 'reserved_quantity' => 0]
            );

            ProductVariant::updateOrCreate(
                ['sku' => $item['sku'] . '-VARIANT'],
                [
                    'product_id' => $product->id,
                    'attributes' => $item['variant_attributes'],
                    'price' => $item['price'],
                    'cost_price' => $product->cost_price ?? 0,
                    'stock' => $item['quantity'],
                    'is_default' => true,
                    'image_url' => $item['image'],
                ]
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
