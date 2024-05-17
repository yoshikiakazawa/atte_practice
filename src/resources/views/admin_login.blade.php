@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('header')
@include('layouts.header_nav_admin_login')
@endsection

@section('content')
<div class="login-form__heading">
    <h2>管理者ログイン</h2>
</div>
<form class="form" action="/admin/login" method="post">
    @csrf
    <div class="form__content">
        <div class="form__input--text">
            <input type="userid" name="userid" value="{{ old('userid') }}" placeholder="userid"/>
        </div>
        <div class="form__error">
            @error('userid')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div class="form__content">
        <div class="form__input--text">
            <input type="password" name="password" placeholder="パスワード"/>
        </div>
        <div class="form__error">
            @error('password')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div class="form__button">
        <button class="form__button-submit" type="submit">ログイン</button>
    </div>
</form>
@endsection
