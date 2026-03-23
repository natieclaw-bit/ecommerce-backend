<!doctype html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>庫存管理</title></head>
<body style="font-family:Arial,sans-serif;max-width:1100px;margin:40px auto;padding:0 16px">
    <h1>庫存管理</h1>
    <p><a href="/admin">回儀表板</a> | <a href="/admin/products">商品管理</a> | <a href="/admin/orders">訂單管理</a></p>
    @if (session('success'))<div style="color:green">{{ session('success') }}</div>@endif
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr><th>商品</th><th>可用庫存</th><th>保留庫存</th><th>最後更新</th><th>操作</th></tr>
        </thead>
        <tbody>
            @forelse($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->product?->name }}</td>
                    <td>{{ $inventory->quantity }}</td>
                    <td>{{ $inventory->reserved_quantity }}</td>
                    <td>{{ $inventory->updated_at }}</td>
                    <td><a href="/admin/inventory/{{ $inventory->id }}/edit">調整</a></td>
                </tr>
            @empty
                <tr><td colspan="5">目前沒有庫存資料</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
