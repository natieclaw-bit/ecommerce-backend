@extends('layouts.admin')

@section('title', '商品管理')

@section('content')
    <div class="surface">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:18px;">
            <div>
                <h1 style="margin:0;">商品管理</h1>
                <p style="margin:6px 0 0;color:var(--muted);">維護 SKU、售價與上架狀態</p>
            </div>
            <a href="/admin/products/create" class="btn btn-primary">＋ 新增商品</a>
        </div>

        @if (session('success'))
            <div style="margin-bottom:16px;padding:12px 16px;border-radius:14px;background:rgba(110,231,183,0.15);color:#a7f3d0;">
                {{ session('success') }}
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>名稱</th>
                    <th>價格</th>
                    <th>狀態</th>
                    <th>庫存</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>#{{ $product->id }}</td>
                        <td style="font-family:'JetBrains Mono',monospace;">{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>NT$ {{ number_format($product->price, 0) }}</td>
                        <td>
                            @php
                                $isActive = $product->status === 'active';
                            @endphp
                            <span class="pill" data-variant="{{ $isActive ? 'success' : 'warning' }}">
                                {{ $isActive ? '上架' : '下架' }}
                            </span>
                        </td>
                        <td>{{ $product->inventory?->quantity ?? 0 }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-ghost" style="padding:6px 12px;">編輯</a>
                                <form method="post" action="/admin/products/{{ $product->id }}" onsubmit="return confirm('確定刪除？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding:6px 12px;">刪除</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;color:var(--muted);">目前沒有商品</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
