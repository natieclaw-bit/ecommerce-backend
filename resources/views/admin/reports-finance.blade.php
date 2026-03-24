@extends('layouts.admin')

@section('title', '帳務報表')

@section('content')
    <div class="surface">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:18px;">
            <div>
                <h1 style="margin:0;">帳務報表</h1>
                <p style="margin:6px 0 0;color:var(--muted);">掌握營收、成本、毛利與熱銷商品</p>
            </div>
        </div>

        <form method="get" action="/admin/reports/finance" style="margin-bottom:20px;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;align-items:end;">
            <label>開始日期
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
            </label>
            <label>結束日期
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
            </label>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">套用期間</button>
                <a href="/admin/reports/finance" class="btn btn-ghost">回到預設（最近 30 天）</a>
            </div>
        </form>

        <div style="margin-bottom:16px;color:var(--muted);">顯示範圍：{{ $rangeSummary }}</div>

        <div class="stats-grid" style="margin-bottom:20px;">
            <div class="stat-card">
                <span>營收</span>
                <strong>NT$ {{ number_format($metrics['revenue'], 0) }}</strong>
            </div>
            <div class="stat-card">
                <span>成本</span>
                <strong>NT$ {{ number_format($metrics['cost'], 0) }}</strong>
            </div>
            <div class="stat-card">
                <span>毛利</span>
                <strong>NT$ {{ number_format($metrics['profit'], 0) }}</strong>
            </div>
            <div class="stat-card">
                <span>平均客單</span>
                <strong>NT$ {{ number_format($metrics['avgOrderValue'], 0) }}</strong>
                <small style="display:block;margin-top:6px;color:var(--muted);">{{ $metrics['orderCount'] }} 筆訂單</small>
            </div>
        </div>

        @unless($hasCostPriceColumn)
            <div style="margin-bottom:18px;padding:12px 14px;border-radius:12px;background:rgba(251,191,36,0.15);color:#fde68a;">
                尚未執行最新 Migration，成本資料暫以 0 計算；請 `php artisan migrate` 後重新整理。
            </div>
        @endunless

        <div class="surface" style="margin-bottom:20px;">
            <h2 class="section-title">狀態分佈</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>狀態</th>
                        <th>筆數</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statusBreakdown as $row)
                        <tr>
                            <td>{{ $row['label'] }} ({{ $row['status'] }})</td>
                            <td>{{ $row['count'] }}</td>
                            <td>NT$ {{ number_format($row['amount'], 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="surface">
            <h2 class="section-title">熱銷商品 TOP 5</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>商品</th>
                        <th>銷售數量</th>
                        <th>營收</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>NT$ {{ number_format($item->revenue, 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center;color:var(--muted);">目前沒有可統計的訂單</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
