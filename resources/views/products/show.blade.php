<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
</head>
<body style="font-family:Arial,sans-serif;max-width:900px;margin:40px auto;padding:0 16px">
    <a href="/products">← 返回商品列表</a>
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <div>SKU：{{ $product->sku }}</div>
    <div>價格：NT$ {{ number_format($product->price, 0) }}</div>
    <div>目前庫存：{{ $product->inventory?->quantity ?? 0 }}</div>
    <button disabled>加入購物車（開發中）</button>
</body>
</html>
