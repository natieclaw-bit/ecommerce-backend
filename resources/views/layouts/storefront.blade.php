<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StockFlow Commerce')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet">
    @yield('head-extra')
    <style>
        :root {
            --bg: #030712;
            --accent: #7b7cff;
            --accent-soft: rgba(123,124,255,0.15);
            --text: rgba(255,255,255,0.92);
            --muted: rgba(255,255,255,0.65);
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top, rgba(123,124,255,0.25), #030712 65%);
            font-family: 'Inter', 'Noto Sans TC', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text);
        }
        .store-shell {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px 64px;
        }
        header.store-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .brand {
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        .btn-link {
            padding: 10px 16px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.2);
            text-decoration: none;
            color: var(--text);
            transition: all 0.2s ease;
        }
        .btn-link:hover {
            border-color: var(--accent);
            box-shadow: 0 10px 24px rgba(0,0,0,0.25);
        }
        .hero {
            margin: 40px 0 32px;
            padding: 36px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(123,124,255,0.2), rgba(110,231,183,0.1));
            border: 1px solid rgba(123,124,255,0.35);
        }
        .hero h1 {
            margin: 0 0 12px;
            font-size: clamp(2rem, 4vw, 2.8rem);
        }
        .hero p {
            margin: 0;
            color: var(--muted);
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.35);
        }
        .price {
            font-weight: 600;
            font-size: 1.1rem;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.75rem;
            background: var(--accent-soft);
            color: var(--text);
        }
        .product-layout {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 32px;
            margin-top: 24px;
        }
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 24px;
        }
        .pretitle {
            letter-spacing: 0.25em;
            font-size: 0.75rem;
            color: var(--muted);
            text-transform: uppercase;
        }
        .breadcrumbs {
            display: inline-flex;
            gap: 8px;
            color: var(--muted);
            font-size: 0.9rem;
        }
        .breadcrumbs .active {
            color: var(--text);
            font-weight: 600;
        }
        .cart-list {
            display: flex;
            flex-direction: column;
        }
        .cart-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item img {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            object-fit: cover;
        }
        .cart-item .info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .cart-item .top h3 {
            margin: 8px 0 4px;
        }
        .cart-item .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .qty {
            display: inline-flex;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 999px;
            padding: 6px;
            gap: 4px;
        }
        .qty input {
            width: 40px;
            background: transparent;
            border: none;
            color: var(--text);
            text-align: center;
            font-size: 1rem;
        }
        .qty-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background: rgba(255,255,255,0.08);
            color: var(--text);
            cursor: pointer;
        }
        .summary-row,
        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .summary-total {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .image-zoom-wrapper {
            position: relative;
        }
        .image-zoom {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .image-zoom img {
            width: 100%;
            display: block;
        }
        .image-zoom-lens {
            position: absolute;
            border: 1px solid rgba(255,255,255,0.6);
            width: 120px;
            height: 120px;
            border-radius: 50%;
            pointer-events: none;
            display: none;
        }
        .zoom-preview {
            margin-top: 12px;
            height: 200px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.1);
            background-size: 200% 200%;
            background-repeat: no-repeat;
            display: none;
        }
        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }
        .lightbox img {
            max-width: 90vw;
            max-height: 90vh;
            border-radius: 20px;
        }
        .timeline {
            border-left: 1px solid rgba(255,255,255,0.1);
            padding-left: 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .timeline-item {
            position: relative;
            padding-left: 8px;
        }
        .timeline-item .dot {
            position: absolute;
            left: -33px;
            top: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            border: 2px solid rgba(255,255,255,0.35);
        }
        .timeline-item.active .dot {
            background: var(--accent);
            border-color: var(--accent);
            box-shadow: 0 0 12px rgba(123,124,255,0.6);
        }
        .card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 24px;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        label {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 0.9rem;
            color: var(--muted);
        }
        input, select, textarea {
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(0,0,0,0.25);
            color: var(--text);
            padding: 10px 14px;
            font-size: 1rem;
            font-family: inherit;
        }
        .payment-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
        }
        .payment-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.02);
        }
        .payment-card input {
            width: auto;
        }
        .cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            border: none;
            padding: 12px 20px;
            border-radius: 999px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="store-shell">
        <header class="store-header">
            <div>
                <div class="brand">StockFlow Commerce</div>
                <small style="color:var(--muted);">精品咖啡 · 當日烘焙 · 迅速出貨</small>
            </div>
            <a href="/admin" class="btn-link">管理者登入</a>
        </header>

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
