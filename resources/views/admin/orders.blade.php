@extends('layouts.admin')

@section('title', '訂單管理')

@section('content')
    <div class="surface">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px;">
            <div>
                <h1 style="margin:0;">訂單管理</h1>
                <p style="margin:6px 0 0;color:var(--muted);">追蹤付款、出貨與完成進度</p>
            </div>
        </div>

        @if (session('success'))
            <div style="margin-bottom:16px;padding:12px 16px;border-radius:14px;background:rgba(110,231,183,0.15);color:#a7f3d0;">
                {{ session('success') }}
            </div>
        @endif

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
                                    @foreach(['pending','paid','packing','shipped','completed','cancelled'] as $status)
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
    </div>
@endsection
