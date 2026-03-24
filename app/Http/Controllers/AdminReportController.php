<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    public function finance(Request $request): View
    {
        $defaultFrom = Carbon::now()->subDays(29)->startOfDay();
        $defaultTo = Carbon::now()->endOfDay();
        $hasFilterInput = $request->hasAny(['date_from', 'date_to']);

        if ($hasFilterInput) {
            $dateFromInput = $request->input('date_from');
            $dateToInput = $request->input('date_to');
            $rangeStart = $dateFromInput ? Carbon::parse($dateFromInput)->startOfDay() : null;
            $rangeEnd = $dateToInput ? Carbon::parse($dateToInput)->endOfDay() : null;
            $formDateFrom = $dateFromInput;
            $formDateTo = $dateToInput;
        } else {
            $rangeStart = $defaultFrom;
            $rangeEnd = $defaultTo;
            $formDateFrom = $defaultFrom->toDateString();
            $formDateTo = $defaultTo->toDateString();
        }

        $fulfilledStatuses = ['paid', 'packing', 'shipped', 'completed'];

        $ordersQuery = Order::query()->whereIn('status', $fulfilledStatuses);
        $this->applyDateFilter($ordersQuery, $rangeStart, $rangeEnd, 'orders.created_at');

        $revenue = (clone $ordersQuery)->sum('total_amount');
        $orderCount = (clone $ordersQuery)->count();
        $avgOrderValue = $orderCount > 0 ? $revenue / $orderCount : 0;

        $hasCostPriceColumn = Schema::hasColumn('products', 'cost_price');
        $cost = 0;

        if ($hasCostPriceColumn) {
            $costQuery = OrderItem::query()
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->whereIn('orders.status', $fulfilledStatuses);

            $this->applyDateFilter($costQuery, $rangeStart, $rangeEnd, 'orders.created_at');
            $cost = (float) $costQuery->sum(DB::raw('order_items.quantity * products.cost_price'));
        }

        $profit = $revenue - $cost;

        $statusAggregates = Order::query()
            ->select('status', DB::raw('COUNT(*) as order_count'), DB::raw('COALESCE(SUM(total_amount), 0) as total_amount'))
            ->when($rangeStart, fn ($query) => $query->where('created_at', '>=', $rangeStart))
            ->when($rangeEnd, fn ($query) => $query->where('created_at', '<=', $rangeEnd))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $statusLabels = [
            'pending' => '待付款',
            'paid' => '已付款',
            'packing' => '備貨中',
            'shipped' => '配送中',
            'completed' => '已完成',
            'cancelled' => '已取消',
        ];

        $statusBreakdown = collect($statusLabels)->map(function ($label, $status) use ($statusAggregates) {
            $record = $statusAggregates->get($status);

            return [
                'status' => $status,
                'label' => $label,
                'count' => $record->order_count ?? 0,
                'amount' => $record->total_amount ?? 0,
            ];
        })->values();

        $topProductsQuery = OrderItem::query()
            ->select([
                'order_items.product_id',
                'order_items.product_name',
                DB::raw('COALESCE(SUM(order_items.subtotal), 0) as revenue'),
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as quantity'),
            ])
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', $fulfilledStatuses)
            ->groupBy('order_items.product_id', 'order_items.product_name');

        $this->applyDateFilter($topProductsQuery, $rangeStart, $rangeEnd, 'orders.created_at');

        $topProducts = $topProductsQuery
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $rangeSummary = $this->formatRangeSummary($rangeStart, $rangeEnd, $hasFilterInput);

        return view('admin.reports-finance', [
            'filters' => [
                'date_from' => $formDateFrom,
                'date_to' => $formDateTo,
                'has_input' => $hasFilterInput,
            ],
            'rangeSummary' => $rangeSummary,
            'metrics' => [
                'revenue' => $revenue,
                'orderCount' => $orderCount,
                'avgOrderValue' => $avgOrderValue,
                'cost' => $cost,
                'profit' => $profit,
            ],
            'statusBreakdown' => $statusBreakdown,
            'topProducts' => $topProducts,
            'hasCostPriceColumn' => $hasCostPriceColumn,
        ]);
    }

    private function applyDateFilter($query, ?Carbon $from, ?Carbon $to, string $column): void
    {
        if ($from) {
            $query->where($column, '>=', $from);
        }

        if ($to) {
            $query->where($column, '<=', $to);
        }
    }

    private function formatRangeSummary(?Carbon $from, ?Carbon $to, bool $hasFilterInput): string
    {
        if (! $from && ! $to) {
            return $hasFilterInput ? '顯示全部期間' : '最近 30 天';
        }

        if ($from && $to) {
            return $from->toDateString() . ' - ' . $to->toDateString();
        }

        if ($from) {
            return $from->toDateString() . ' 起';
        }

        return '截至 ' . $to->toDateString();
    }
}
