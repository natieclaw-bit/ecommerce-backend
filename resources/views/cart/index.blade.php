@extends('layouts.storefront')

@section('title', '購物車｜StockFlow Commerce')

@section('content')
    <div class="section-header">
        <div>
            <p class="pretitle">STEP 1 / 3</p>
            <h1 style="margin:0;">購物車</h1>
            <p style="color:var(--muted);margin-top:4px;">確認商品內容，下一步填寫收件資訊。</p>
        </div>
        <div class="breadcrumbs">
            <span class="active">購物車</span>
            <span>→</span>
            <span>結帳資訊</span>
            <span>→</span>
            <span>完成</span>
        </div>
    </div>

    <div class="product-layout" style="align-items:flex-start;">
        <div class="card" style="padding:0;">
            <div class="cart-list">
                @foreach($cartItems as $item)
                    <div class="cart-item" data-price="{{ $item['price'] }}">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                        <div class="info">
                            <div class="top">
                                <span class="badge">SKU {{ $item['sku'] }}</span>
                                <h3>{{ $item['name'] }}</h3>
                                <p>NT$ {{ number_format($item['price'], 0) }}</p>
                            </div>
                            <div class="actions">
                                <div class="qty" data-qty>
                                    <button type="button" class="qty-btn" data-decrease>-</button>
                                    <input type="number" value="{{ $item['quantity'] }}" min="1">
                                    <button type="button" class="qty-btn" data-increase>+</button>
                                </div>
                                <div class="line-total" data-line-total>NT$ {{ number_format($item['price'] * $item['quantity'], 0) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <h2 style="margin-top:0;">結帳摘要</h2>
            <div class="summary-row">
                <span>小計</span>
                <span data-subtotal>NT$ {{ number_format($summary['subtotal'], 0) }}</span>
            </div>
            <div class="summary-row">
                <span>運費</span>
                <span>NT$ {{ number_format($summary['shipping'], 0) }}</span>
            </div>
            <div class="summary-row">
                <span>折扣</span>
                <span>NT$ {{ number_format($summary['discount'], 0) }}</span>
            </div>
            <div class="summary-total">
                <span>應付金額</span>
                <strong data-total>NT$ {{ number_format($summary['total'], 0) }}</strong>
            </div>
            <a class="cta" href="/checkout" style="display:block;text-align:center;">前往結帳</a>
            <button class="btn-link" style="margin-top:12px;" onclick="history.back()">← 繼續逛逛</button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function(){
    const currency = value => `NT$ ${value.toLocaleString('zh-TW')}`;
    const items = document.querySelectorAll('.cart-item');
    const subtotalEl = document.querySelector('[data-subtotal]');
    const totalEl = document.querySelector('[data-total]');
    const shipping = {{ $summary['shipping'] }};
    const discount = {{ $summary['discount'] }};

    const recalc = () => {
        let subtotal = 0;
        items.forEach(item => {
            const price = Number(item.dataset.price);
            const qtyInput = item.querySelector('input');
            const qty = Math.max(1, Number(qtyInput.value) || 1);
            const lineTotal = price * qty;
            item.querySelector('[data-line-total]').textContent = currency(lineTotal);
            subtotal += lineTotal;
        });
        subtotalEl.textContent = currency(subtotal);
        totalEl.textContent = currency(subtotal + shipping - discount);
    };

    items.forEach(item => {
        const input = item.querySelector('input');
        item.querySelector('[data-increase]').addEventListener('click', () => {
            input.value = Number(input.value) + 1;
            recalc();
        });
        item.querySelector('[data-decrease]').addEventListener('click', () => {
            input.value = Math.max(1, Number(input.value) - 1);
            recalc();
        });
        input.addEventListener('change', recalc);
    });
})();
</script>
@endpush
