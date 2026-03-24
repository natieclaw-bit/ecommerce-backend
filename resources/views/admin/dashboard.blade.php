@extends('layouts.admin')

@section('title', '後台儀表板')

@section('content')
    <div class="surface">
        <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;">
            <div>
                <h1 style="margin:0;font-size:1.6rem;">今日概況</h1>
                <p style="margin:6px 0 0;color:var(--muted);">快速檢視商品、庫存與訂單熱度</p>
            </div>
            <form method="post" action="/admin/logout" class="table-actions" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-ghost">登出帳號</button>
            </form>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <span>商品總數</span>
                <strong>{{ number_format($stats['products']) }}</strong>
                <small style="color:var(--muted);">含上/下架所有品項</small>
            </div>
            <div class="stat-card">
                <span>低庫存商品</span>
                <strong>{{ number_format($stats['low_stock']) }}</strong>
                <small style="color:var(--muted);">需要補貨的 SKU</small>
            </div>
            <div class="stat-card">
                <span>今日訂單</span>
                <strong>{{ number_format($stats['orders_today']) }}</strong>
                <small style="color:var(--muted);">截自現在的流量</small>
            </div>
            <div class="stat-card">
                <span>待處理訂單</span>
                <strong>{{ number_format($stats['pending_orders']) }}</strong>
                <small style="color:var(--muted);">尚未完成的流程</small>
            </div>
        </div>
    </div>

    <div class="surface">
        <h2 class="section-title">快速入口</h2>
        <div class="stats-grid">
            <a class="stat-card" href="/admin/products">
                <span>商品管理</span>
                <strong>新增 / 編輯 / 下架</strong>
            </a>
            <a class="stat-card" href="/admin/inventory">
                <span>庫存監控</span>
                <strong>即時補貨提醒</strong>
            </a>
            <a class="stat-card" href="/admin/orders">
                <span>訂單追蹤</span>
                <strong>狀態更新與備註</strong>
            </a>
        </div>
    </div>

    @if($lowStockProducts->isNotEmpty())
        <div class="surface">
            <h2 class="section-title">低庫存告警</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>名稱</th>
                        <th>目前庫存</th>
                        <th>狀態</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $product)
                        <tr>
                            <td style="font-family:'JetBrains Mono',monospace;">{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->inventory?->quantity ?? 0 }}</td>
                            <td>
                                <span class="pill" data-variant="warning">待補貨</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if($recentOrders->isNotEmpty())
        <div class="surface">
            <h2 class="section-title">最新訂單時間線</h2>
            <div class="timeline">
                @foreach($recentOrders as $order)
                    @php
                        $latestLog = $order->statusLogs->sortByDesc('created_at')->first();
                    @endphp
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
                                <div>
                                    <div class="timeline-title">{{ $order->order_no }}</div>
                                    <div style="color:var(--muted);font-size:0.9rem;">{{ $order->contact_name }} · NT$ {{ number_format($order->total_amount, 0) }}</div>
                                </div>
                                <span class="pill" data-variant="{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div style="margin-top:8px;color:var(--muted);font-size:0.85rem;">
                                @if($latestLog)
                                    {{ $latestLog->created_at->diffForHumans() }} · {{ $latestLog->note ?? '狀態更新' }}
                                @else
                                    {{ $order->updated_at->diffForHumans() }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
