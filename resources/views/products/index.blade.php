<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>商品列表</title>
    <style>body{font-family:Arial,sans-serif;max-width:960px;margin:40px auto;padding:0 16px}.card{border:1px solid #ddd;border-radius:12px;padding:16px;margin-bottom:12px}</style>
</head>
<body>
    <h1>商品列表</h1>
    <p>客戶可瀏覽庫存與價格並準備下單。</p>

    @forelse($products as $product)
        <div class="card">
            <h2>{{ $product->name }}</h2>
            <div>SKU：{{ $product->sku }}</div>
            <div>價格：NT$ {{ number_format($product->price, 0) }}</div>
            <div>庫存：{{ $product->inventory?->quantity ?? 0 }}</div>
            <a href="/products/{{ $product->id }}">查看商品</a>
        </div>
    @empty
        <p>目前尚無商品資料。</p>
    @endforelse
</body>
</html>
