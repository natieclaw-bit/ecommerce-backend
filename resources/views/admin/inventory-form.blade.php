<!doctype html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>調整庫存</title></head>
<body style="font-family:Arial,sans-serif;max-width:900px;margin:40px auto;padding:0 16px">
<h1>調整庫存：{{ $inventory->product?->name }}</h1>
<p><a href="/admin/inventory">返回庫存管理</a></p>
@if ($errors->any())
    <div style="color:red"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<form method="post" action="/admin/inventory/{{ $inventory->id }}">
    @csrf
    @method('PUT')
    <div><label>可用庫存 <input type="number" name="quantity" value="{{ old('quantity', $inventory->quantity) }}"></label></div>
    <div><label>保留庫存 <input type="number" name="reserved_quantity" value="{{ old('reserved_quantity', $inventory->reserved_quantity) }}"></label></div>
    <button type="submit">更新</button>
</form>
</body>
</html>
