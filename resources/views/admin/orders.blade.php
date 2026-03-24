@extends('layouts.admin')

@section('title', '訂單管理')

@section('content')
    <div class="surface">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px;flex-wrap:wrap;">
            <div>
                <h1 style="margin:0;">訂單管理</h1>
                <p style="margin:6px 0 0;color:var(--muted);">搜尋訂單、篩選付款 / 出貨狀態並快速更新流程</p>
            </div>
        </div>

        <form method="get" action="/admin/orders" style="margin-bottom:20px;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;align-items:end;">
            <label>訂單 / 客戶關鍵字
                <input type="text" name="keyword" value="{{ $filters['keyword'] ?? '' }}" placeholder="編號、姓名、電話">
            </label>
            <label>狀態
                <select name="status">
                    <option value="">全部</option>
                    @foreach($statusOptions as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </label>
            <label>建立日期（起）
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
            </label>
            <label>建立日期（迄）
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
            </label>
            <label>最低金額 (NT$)
                <input type="number" name="amount_min" step="1" value="{{ $filters['amount_min'] ?? '' }}">
            </label>
            <label>最高金額 (NT$)
                <input type="number" name="amount_max" step="1" value="{{ $filters['amount_max'] ?? '' }}">
            </label>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">套用篩選</button>
                <a href="/admin/orders" class="btn btn-ghost">重設條件</a>
            </div>
        </form>

        @php $totalOrders = $orders->total(); @endphp
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;color:var(--muted);flex-wrap:wrap;gap:12px;">
            <div>共 {{ $totalOrders }} 筆訂單</div>
            @if (session('success'))
                <div style="padding:8px 12px;border-radius:12px;background:rgba(110,231,183,0.15);color:#a7f3d0;">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        @php
            $statusVariants = [
                'pending' => 'warning',
                'paid' => 'info',
                'packing' => 'info',
                'shipped' => 'info',
                'completed' => 'success',
                'cancelled' => 'danger',
            ];
        @endphp

        <table class="data-table">
            <thead>
                <tr>
                    <th>訂單編號</th>
                    <th>客戶姓名</th>
                    <th>狀態</th>
                    <th>金額</th>
                    <th style="width:220px;">更新狀態</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td style="font-family:'JetBrains Mono',monospace;">{{ $order->order_no }}</td>
                        <td>{{ $order->contact_name }}</td>
                        <td>
                            @php $variant = $statusVariants[$order->status] ?? 'info'; @endphp
                            <span class="pill" data-variant="{{ $variant }}">{{ $order->status }}</span>
                        </td>
                        <td>NT$ {{ number_format($order->total_amount, 0) }}</td>
                        <td>
                            <form method="post" action="/admin/orders/{{ $order->id }}/status" style="display:flex;gap:10px;align-items:center;">
                                @csrf
                                @method('PUT')
                                <select name="status">
                                    @foreach($statusOptions as $status)
                                        <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary" style="padding:6px 12px;">更新</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:var(--muted);">目前沒有訂單</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:18px;">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
