<!doctype html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>訂單管理</title></head>
<body style="font-family:Arial,sans-serif;max-width:1100px;margin:40px auto;padding:0 16px">
    <h1>訂單管理</h1>
    <p><a href="/admin">回儀表板</a> | <a href="/admin/products">商品管理</a> | <a href="/admin/inventory">庫存管理</a></p>
    @if (session('success'))<div style="color:green">{{ session('success') }}</div>@endif
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr><th>訂單編號</th><th>客戶</th><th>狀態</th><th>金額</th><th>更新狀態</th></tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_no }}</td>
                    <td>{{ $order->contact_name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>NT$ {{ number_format($order->total_amount, 0) }}</td>
                    <td>
                        <form method="post" action="/admin/orders/{{ $order->id }}/status">
                            @csrf @method('PUT')
                            <select name="status">
                                @foreach(['pending','paid','packing','shipped','completed','cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                            <button type="submit">更新</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">目前沒有訂單</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
