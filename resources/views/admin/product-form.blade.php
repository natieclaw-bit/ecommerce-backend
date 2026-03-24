@extends('layouts.admin')

@section('title', $mode === 'create' ? '新增商品' : '編輯商品')

@section('content')
    <div class="surface">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px;">
            <div>
                <h1 style="margin:0;">{{ $mode === 'create' ? '新增商品' : '編輯商品' }}</h1>
                <p style="margin:6px 0 0;color:var(--muted);">設定 SKU、售價以及初始庫存</p>
            </div>
            <a href="/admin/products" class="btn btn-ghost">返回列表</a>
        </div>

        @if ($errors->any())
            <div style="margin-bottom:18px;padding:12px 16px;border-radius:14px;background:rgba(248,113,113,0.15);color:#fecaca;">
                <ul style="padding-left:18px;margin:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ $mode === 'create' ? '/admin/products' : '/admin/products/' . $product->id }}" class="form-grid">
            @csrf
            @if($mode === 'edit')
                @method('PUT')
            @endif

            <label>SKU
                <input name="sku" value="{{ old('sku', $product->sku) }}" required>
            </label>
            <label>名稱
                <input name="name" value="{{ old('name', $product->name) }}" required>
            </label>
            <label>價格 (NT$)
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
            </label>
            <label>狀態
                <select name="status">
                    <option value="active" @selected(old('status', $product->status ?: 'active') === 'active')>上架 (active)</option>
                    <option value="inactive" @selected(old('status', $product->status) === 'inactive')>下架 (inactive)</option>
                </select>
            </label>
            <label>庫存數量
                <input type="number" name="quantity" value="{{ old('quantity', $inventoryQty) }}" min="0">
            </label>
            <label>商品描述
                <textarea name="description">{{ old('description', $product->description) }}</textarea>
            </label>
            <button type="submit" class="btn btn-primary">儲存商品</button>
        </form>
    </div>
@endsection
