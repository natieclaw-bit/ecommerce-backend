<!doctype html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>{{ $mode === 'create' ? '新增商品' : '編輯商品' }}</title></head>
<body style="font-family:Arial,sans-serif;max-width:900px;margin:40px auto;padding:0 16px">
<h1>{{ $mode === 'create' ? '新增商品' : '編輯商品' }}</h1>
<p><a href="/admin/products">返回商品管理</a></p>
@if ($errors->any())
    <div style="color:red"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<form method="post" action="{{ $mode === 'create' ? '/admin/products' : '/admin/products/' . $product->id }}">
    @csrf
    @if($mode === 'edit') @method('PUT') @endif
    <div><label>SKU <input name="sku" value="{{ old('sku', $product->sku) }}"></label></div>
    <div><label>名稱 <input name="name" value="{{ old('name', $product->name) }}"></label></div>
    <div><label>價格 <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}"></label></div>
    <div><label>狀態
        <select name="status">
            <option value="active" @selected(old('status', $product->status ?: 'active') === 'active')>active</option>
            <option value="inactive" @selected(old('status', $product->status) === 'inactive')>inactive</option>
        </select>
    </label></div>
    <div><label>初始/目前庫存 <input type="number" name="quantity" value="{{ old('quantity', $inventoryQty) }}"></label></div>
    <div><label>描述<br><textarea name="description" rows="5" cols="80">{{ old('description', $product->description) }}</textarea></label></div>
    <button type="submit">儲存</button>
</form>
</body>
</html>
