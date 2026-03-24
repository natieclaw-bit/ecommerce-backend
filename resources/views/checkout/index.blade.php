@extends('layouts.storefront')

@section('title', '結帳資訊｜StockFlow Commerce')

@section('content')
    <div class="section-header">
        <div>
            <p class="pretitle">STEP 2 / 3</p>
            <h1 style="margin:0;">結帳資訊</h1>
            <p style="color:var(--muted);margin-top:4px;">填寫收件資料與付款方式，確認金額後提交訂單。</p>
        </div>
        <div class="breadcrumbs">
            <span>購物車</span>
            <span>→</span>
            <span class="active">結帳資訊</span>
            <span>→</span>
            <span>完成</span>
        </div>
    </div>

    <div class="product-layout" style="align-items:flex-start;">
        <div class="card">
            <h2 style="margin-top:0;">收件資訊</h2>
            <div class="form-grid">
                <label>聯絡人
                    <input type="text" placeholder="王小明">
                </label>
                <label>聯絡電話
                    <input type="tel" placeholder="0912-345-678">
                </label>
                <label>電子信箱
                    <input type="email" placeholder="customer@stockflow.test">
                </label>
                <label>配送方式
                    <select>
                        @foreach($orderPreview['shipping_methods'] as $method)
                            <option>{{ $method }}</option>
                        @endforeach
                    </select>
                </label>
                <label>收件地址
                    <input type="text" placeholder="台北市信義區示範路 1 號">
                </label>
                <label>備註（選填）
                    <textarea rows="3" placeholder="若有特殊配送需求可填寫於此"></textarea>
                </label>
            </div>

            <h2>付款方式</h2>
            <div class="payment-options">
                @foreach($orderPreview['payment_methods'] as $method)
                    <label class="payment-card">
                        <input type="radio" name="payment" {{ $loop->first ? 'checked' : '' }}>
                        <div>{{ $method }}</div>
                    </label>
                @endforeach
            </div>

            <button class="cta" style="margin-top:16px;">提交訂單（模擬）</button>
        </div>
        <div class="card">
            <h2 style="margin-top:0;">訂單摘要</h2>
            <div class="summary-list">
                @foreach($orderPreview['items'] as $item)
                    <div class="summary-row">
                        <div>
                            <strong>{{ $item['name'] }}</strong>
                            <p style="margin:0;color:var(--muted);">x{{ $item['quantity'] }}</p>
                        </div>
                        <span>NT$ {{ number_format($item['price'] * $item['quantity'], 0) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="summary-row">
                <span>小計</span>
                <span>NT$ {{ number_format($orderPreview['subtotal'], 0) }}</span>
            </div>
            <div class="summary-row">
                <span>運費</span>
                <span>NT$ {{ number_format($orderPreview['shipping'], 0) }}</span>
            </div>
            <div class="summary-total">
                <span>應付金額</span>
                <strong>NT$ {{ number_format($orderPreview['total'], 0) }}</strong>
            </div>
            <a href="/orders/tracking" class="btn-link" style="display:block;text-align:center;margin-top:12px;">查看訂單進度</a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // placeholder for future form submission logic
</script>
@endpush
