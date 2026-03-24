@extends('layouts.storefront')

@section('title', $product->name . '｜StockFlow Commerce')

@section('content')
    <a href="/products" class="btn-link" style="margin-bottom:16px;display:inline-flex;align-items:center;gap:6px;">← 返回商品列表</a>

    <div class="product-layout">
        <div class="card">
            <div class="badge">SKU {{ $product->sku }}</div>
            @if($product->image_url)
                <div class="image-zoom-wrapper">
                    <div class="image-zoom" data-image="{{ $product->image_url }}">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        <div class="image-zoom-lens"></div>
                    </div>
                    <div class="zoom-preview"></div>
                </div>
                <button class="cta" id="open-lightbox" style="margin-top:12px;">全螢幕查看</button>
            @endif
            <h1 style="margin:12px 0 8px;">{{ $product->name }}</h1>
            <p style="margin:0 0 16px;color:var(--muted);white-space:pre-line;">{{ $product->description }}</p>
            <div class="price" style="font-size:1.6rem;">NT$ {{ number_format($product->price, 0) }}</div>
            <div style="margin:16px 0;color:var(--muted);">庫存：{{ $product->inventory?->quantity ?? 0 }}</div>
            <button class="cta" disabled>加入購物車（開發中）</button>
        </div>
        <div class="card" style="background:rgba(123,124,255,0.08);border-color:rgba(123,124,255,0.35);">
            <h2 style="margin-top:0;">風味筆記</h2>
            <ul style="padding-left:18px;color:var(--muted);line-height:1.6;">
                <li>烘焙至中深焙，保留果酸與巧克力韻味</li>
                <li>下單後 24 小時內烘焙裝袋</li>
                <li>全程冷鏈配送確保新鮮</li>
            </ul>
        </div>
    </div>

    <div class="lightbox" id="lightbox">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
    </div>
@endsection

@push('scripts')
<script>
(function() {
    const zoomContainer = document.querySelector('.image-zoom');
    if (!zoomContainer) return;

    const lens = zoomContainer.querySelector('.image-zoom-lens');
    const preview = document.querySelector('.zoom-preview');
    const img = zoomContainer.querySelector('img');
    const lightbox = document.getElementById('lightbox');
    const openLightbox = document.getElementById('open-lightbox');

    const imageSrc = zoomContainer.dataset.image;
    preview.style.backgroundImage = `url(${imageSrc})`;

    const moveLens = (e) => {
        const rect = zoomContainer.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        lens.style.display = 'block';
        preview.style.display = 'block';
        let lensX = x - lens.offsetWidth / 2;
        let lensY = y - lens.offsetHeight / 2;
        lensX = Math.max(0, Math.min(lensX, rect.width - lens.offsetWidth));
        lensY = Math.max(0, Math.min(lensY, rect.height - lens.offsetHeight));
        lens.style.transform = `translate(${lensX}px, ${lensY}px)`;
        const percentX = lensX / rect.width * 100;
        const percentY = lensY / rect.height * 100;
        preview.style.backgroundPosition = `${percentX}% ${percentY}%`;
    };

    zoomContainer.addEventListener('mousemove', moveLens);
    zoomContainer.addEventListener('mouseleave', () => {
        lens.style.display = 'none';
        preview.style.display = 'none';
    });

    if (openLightbox) {
        openLightbox.addEventListener('click', () => {
            lightbox.style.display = 'flex';
        });
    }
    lightbox.addEventListener('click', () => {
        lightbox.style.display = 'none';
    });
})();
</script>
@endpush
