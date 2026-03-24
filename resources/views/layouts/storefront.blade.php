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
        .card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 24px;
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
