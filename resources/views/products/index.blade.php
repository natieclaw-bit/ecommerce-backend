@extends('layouts.storefront')

@section('title', '精品咖啡商品列表')

@section('content')
    <section class="hero">
        <h1>新鮮烘焙 · 即刻下單</h1>
        <p>每一批豆子都由專人烘焙，再由我們的智慧庫存系統控管出貨。</p>
    </section>

    @if($products->isEmpty())
        <div class="card" style="text-align:center;color:var(--muted);">
            目前尚無商品，請稍後再看看。
        </div>
    @else
        <div class="product-grid">
            @foreach($products as $product)
                <a href="/products/{{ $product->id }}" class="product-card">
                    <div class="badge">SKU {{ $product->sku }}</div>
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width:100%;height:180px;object-fit:cover;border-radius:12px;" loading="lazy">
                    @endif
                    <h2 style="margin:8px 0 0;">{{ $product->name }}</h2>
                    <p style="margin:0;color:var(--muted);">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                    <div class="price">NT$ {{ number_format($product->price, 0) }}</div>
                    <div style="color:var(--muted);font-size:0.85rem;">庫存：{{ $product->inventory?->quantity ?? 0 }}</div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
