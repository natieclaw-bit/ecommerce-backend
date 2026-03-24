<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StockFlow Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet">
    @yield('head-extra')
    <style>
        :root {
            --bg: #050816;
            --bg-gradient: radial-gradient(circle at top, #1b2b65 0, #050816 60%);
            --surface: rgba(255, 255, 255, 0.05);
            --surface-border: rgba(255, 255, 255, 0.07);
            --surface-hover: rgba(255, 255, 255, 0.09);
            --text: rgba(255, 255, 255, 0.92);
            --muted: rgba(255, 255, 255, 0.6);
            --primary: #7b7cff;
            --primary-accent: #6ee7b7;
            --danger: #f87171;
            --warning: #fbbf24;
            --success: #34d399;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', 'Noto Sans TC', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-gradient);
            color: var(--text);
        }
        .app-shell {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 64px;
        }
        header.top-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }
        .brand {
            font-weight: 600;
            letter-spacing: 0.04em;
        }
        nav.admin-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        nav.admin-nav a {
            text-decoration: none;
            color: var(--muted);
            padding: 8px 14px;
            border-radius: 999px;
            border: 1px solid transparent;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        nav.admin-nav a:hover {
            border-color: var(--surface-border);
            color: var(--text);
        }
        nav.admin-nav a.is-active {
            background: var(--surface);
            border-color: var(--primary);
            color: var(--text);
            box-shadow: inset 0 0 12px rgba(123, 124, 255, 0.3);
        }
        main {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .surface {
            background: var(--surface);
            border: 1px solid var(--surface-border);
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 20px 60px rgba(5, 8, 22, 0.55);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
        }
        .stat-card {
            padding: 18px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(123,124,255,0.18), rgba(110,231,183,0.08));
            border: 1px solid rgba(123,124,255,0.35);
            text-decoration: none;
            color: inherit;
            display: block;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(123,124,255,0.25);
        }
        .stat-card span {
            display: block;
            font-size: 0.85rem;
            color: var(--muted);
        }
        .stat-card strong {
            font-size: 1.8rem;
            font-weight: 600;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table th,
        table.data-table td {
            padding: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-align: left;
        }
        table.data-table th {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
        }
        table.data-table tr:hover td {
            background: rgba(255,255,255,0.02);
        }
        .btn,
        button,
        input[type="submit"] {
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            color: #fff;
            box-shadow: 0 10px 25px rgba(123,124,255,0.35);
        }
        .btn-ghost {
            background: transparent;
            border: 1px solid var(--surface-border);
            color: var(--text);
        }
        .btn-danger { background: linear-gradient(135deg, #fb7185, #f43f5e); color:#fff; }
        .btn:hover { transform: translateY(-1px); }
        form .form-grid {
            display: grid;
            gap: 18px;
        }
        label {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 0.9rem;
            color: var(--muted);
        }
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        textarea,
        select {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 12px 14px;
            color: var(--text);
            font-family: inherit;
        }
        textarea { min-height: 120px; }
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .pill[data-variant="warning"] { background: rgba(251,191,36,0.15); color: #fde68a; }
        .pill[data-variant="success"] { background: rgba(52,211,153,0.15); color: #a7f3d0; }
        .pill[data-variant="info"] { background: rgba(129, 140, 248, 0.2); color: #dbeafe; }
        .pill[data-variant="danger"] { background: rgba(248,113,113,0.2); color: #fecaca; }
        .section-title {
            margin: 0 0 16px;
            font-size: 1.2rem;
        }
        .table-actions {
            display: flex;
            gap: 8px;
        }
        .timeline {
            display: flex;
            flex-direction: column;
            gap: 18px;
            position: relative;
            padding-left: 18px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(255,255,255,0.1);
        }
        .timeline-item {
            display: flex;
            gap: 12px;
            position: relative;
        }
        .timeline-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary);
            position: absolute;
            left: -12px;
            top: 8px;
            box-shadow: 0 0 12px rgba(123,124,255,0.5);
        }
        .timeline-content {
            flex: 1;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 14px 18px;
        }
        .timeline-title {
            font-weight: 600;
        }
        .layout-centered {
            min-height: calc(100vh - 80px);
            display: grid;
            place-items: center;
        }
        .auth-card {
            width: min(420px, 100%);
            padding: 32px;
            background: var(--surface);
            border: 1px solid var(--surface-border);
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
        }
        @media (max-width: 720px) {
            header.top-bar { flex-direction: column; align-items: flex-start; }
            .surface { padding: 18px; }
            table.data-table th, table.data-table td { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="app-shell @yield('body-class')">
        <header class="top-bar">
            <div>
                <div class="brand">StockFlow Admin</div>
                <small style="color: var(--muted);">實時掌握商品、庫存與訂單</small>
            </div>
            @hasSection('suppress-nav')
            @else
                @php
                    $navLinks = [
                        ['label' => '儀表板', 'href' => '/admin', 'pattern' => 'admin'],
                        ['label' => '商品管理', 'href' => '/admin/products', 'pattern' => 'admin/products*'],
                        ['label' => '庫存監控', 'href' => '/admin/inventory', 'pattern' => 'admin/inventory*'],
                        ['label' => '訂單追蹤', 'href' => '/admin/orders', 'pattern' => 'admin/orders*'],
                    ];
                @endphp
                <nav class="admin-nav">
                    @foreach($navLinks as $link)
                        @php $active = request()->is($link['pattern']); @endphp
                        <a href="{{ $link['href'] }}" class="{{ $active ? 'is-active' : '' }}">{{ $link['label'] }}</a>
                    @endforeach
                </nav>
            @endif
        </header>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
