<!doctype html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>管理者登入</title></head>
<body style="font-family:Arial,sans-serif;max-width:500px;margin:60px auto;padding:0 16px">
    <h1>管理者登入</h1>
    <p>測試帳號：admin@stockflow.test / password</p>
    @if ($errors->any())
        <div style="color:red"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form method="post" action="/admin/login">
        @csrf
        <div style="margin-bottom:12px"><label>Email<br><input type="email" name="email" value="{{ old('email') }}" style="width:100%"></label></div>
        <div style="margin-bottom:12px"><label>Password<br><input type="password" name="password" style="width:100%"></label></div>
        <div style="margin-bottom:12px"><label><input type="checkbox" name="remember" value="1"> 記住我</label></div>
        <button type="submit">登入</button>
    </form>
</body>
</html>
