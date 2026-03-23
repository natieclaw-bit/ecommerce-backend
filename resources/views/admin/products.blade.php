<!doctype html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>商品管理</title></head>
<body style="font-family:Arial,sans-serif;max-width:1100px;margin:40px auto;padding:0 16px">
    <h1>商品管理</h1>
    <p><a href="/admin">回儀表板</a> | <a href="/admin/inventory">庫存管理</a> | <a href="/admin/orders">訂單管理</a></p>
    <p><a href="/admin/products/create">＋ 新增商品</a></p>
    @if (session('success'))<div style="color:green">{{ session('success') }}</div>@endif
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr><th>ID</th><th>SKU</th><th>名稱</th><th>價格</th><th>狀態</th><th>庫存</th><th>操作</th></tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td>NT$ {{ number_format($product->price, 0) }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->inventory?->quantity ?? 0 }}</td>
                    <td>
                        <a href="/admin/products/{{ $product->id }}/edit">編輯</a>
                        <form method="post" action="/admin/products/{{ $product->id }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('確定刪除？')">刪除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">目前沒有商品</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
