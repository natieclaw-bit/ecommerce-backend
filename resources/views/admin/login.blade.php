@extends('layouts.admin')

@section('suppress-nav', true)
@section('body-class', 'layout-centered')
@section('title', '管理者登入')

@section('content')
    <div class="auth-card">
        <h1 style="margin-top:0;margin-bottom:8px;">管理者登入</h1>
        <p style="margin-top:0;margin-bottom:18px;color:var(--muted);">測試帳號：admin@stockflow.test / password</p>

        @if ($errors->any())
            <div style="margin-bottom:18px;padding:12px;border-radius:12px;background:rgba(248,113,113,0.15);color:#fecaca;">
                <ul style="padding-left:18px;margin:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="/admin/login" class="form-grid">
            @csrf
            <label>Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label>密碼
                <input type="password" name="password" required>
            </label>
            <label style="flex-direction:row;align-items:center;gap:10px;">
                <input type="checkbox" name="remember" value="1" style="width:auto;"> 記住我
            </label>
            <button type="submit" class="btn btn-primary" style="width:100%;margin-top:6px;">登入後台</button>
        </form>
    </div>
@endsection
