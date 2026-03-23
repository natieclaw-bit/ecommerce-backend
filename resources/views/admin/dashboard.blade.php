<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>後台儀表板</title>
    <style>body{font-family:Arial,sans-serif;max-width:960px;margin:40px auto;padding:0 16px}.grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}.card{border:1px solid #ddd;border-radius:12px;padding:16px}</style>
</head>
<body>
    <h1>管理後台儀表板</h1>
    <form method="post" action="/admin/logout" style="margin-bottom:16px">@csrf <button type="submit">登出</button></form>
    <div class="grid">
        <div class="card">商品數：{{ $stats['products'] }}</div>
        <div class="card">低庫存商品：{{ $stats['low_stock'] }}</div>
        <div class="card">今日訂單：{{ $stats['orders_today'] }}</div>
        <div class="card">待處理訂單：{{ $stats['pending_orders'] }}</div>
    </div>
    <p style="margin-top:16px">
        <a href="/admin/products">商品管理</a> |
        <a href="/admin/inventory">庫存管理</a> |
        <a href="/admin/orders">訂單管理</a>
    </p>
</body>
</html>
