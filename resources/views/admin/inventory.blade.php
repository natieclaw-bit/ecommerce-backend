@extends('layouts.admin')

@section('title', '庫存管理')

@section('content')
    <div class="surface">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px;">
            <div>
                <h1 style="margin:0;">庫存管理</h1>
                <p style="margin:6px 0 0;color:var(--muted);">掌握可用量與保留量，及時補貨</p>
            </div>
        </div>

        @if (session('success'))
            <div style="margin-bottom:16px;padding:12px 16px;border-radius:14px;background:rgba(110,231,183,0.15);color:#a7f3d0;">
                {{ session('success') }}
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th>商品</th>
                    <th>可用庫存</th>
                    <th>保留庫存</th>
                    <th>最後更新</th>
                    <th style="width:120px;">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->product?->name }}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>{{ $inventory->reserved_quantity }}</td>
                        <td>{{ $inventory->updated_at->diffForHumans() }}</td>
                        <td>
                            <a href="/admin/inventory/{{ $inventory->id }}/edit" class="btn btn-ghost" style="padding:6px 12px;">調整</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:var(--muted);">目前沒有庫存資料</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
