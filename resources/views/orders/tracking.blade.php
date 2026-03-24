@extends('layouts.storefront')

@section('title', '訂單追蹤｜StockFlow Commerce')

@section('content')
    <div class="section-header">
        <div>
            <p class="pretitle">STEP 3 / 3</p>
            <h1 style="margin:0;">訂單追蹤</h1>
            <p style="color:var(--muted);margin-top:4px;">訂單編號 {{ $orderNumber }}，即時掌握最新進度。</p>
        </div>
        <div class="breadcrumbs">
            <span>購物車</span>
            <span>→</span>
            <span>結帳資訊</span>
            <span>→</span>
            <span class="active">完成</span>
        </div>
    </div>

    <div class="card" style="margin-top:24px;">
        <div class="timeline">
            @foreach($timeline as $log)
                <div class="timeline-item {{ $loop->last ? 'active' : '' }}">
                    <div class="dot"></div>
                    <div>
                        <strong>{{ strtoupper($log['status']) }}</strong>
                        <p style="margin:4px 0;color:var(--muted);">{{ $log['label'] }}</p>
                        <small style="color:var(--muted);">
                            {{ optional($log['timestamp'])->timezone('Asia/Taipei')->format('Y/m/d H:i') ?? '---' }}
                        </small>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;">
            <a href="/products" class="btn-link">返回商店</a>
            <a href="mailto:customer@stockflow.test" class="btn-link">聯絡客服</a>
        </div>
    </div>
@endsection
