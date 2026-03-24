@extends('layouts.admin')

@section('title', '調整庫存')

@section('content')
    <div class="surface">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px;">
            <div>
                <h1 style="margin:0;">調整庫存：{{ $inventory->product?->name }}</h1>
                <p style="margin:6px 0 0;color:var(--muted);">即時同步可用量與保留量</p>
            </div>
            <a href="/admin/inventory" class="btn btn-ghost">返回庫存列表</a>
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

        <form method="post" action="/admin/inventory/{{ $inventory->id }}" class="form-grid">
            @csrf
            @method('PUT')

            <label>可用庫存
                <input type="number" name="quantity" value="{{ old('quantity', $inventory->quantity) }}" min="0">
            </label>
            <label>保留庫存
                <input type="number" name="reserved_quantity" value="{{ old('reserved_quantity', $inventory->reserved_quantity) }}" min="0">
            </label>
            <button type="submit" class="btn btn-primary">更新庫存</button>
        </form>
    </div>
@endsection
