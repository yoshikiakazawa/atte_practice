@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('nav')
<nav>
    <ul class="header-nav">
        <li class="header-nav__item">
        <a class="header-nav__link" href="/">ホーム</a>
        </li>
        <li class="header-nav__item">
            <a class="header-nav__link" href="/attendance">日付一覧</a>
            </li>
        <li class="header-nav__item">
            <form class="form" action="/logout" method="post">
                @csrf
            <button class="header-nav__button">ログアウト</button>
        </form>
        </li>
    </ul>
</nav>
@endsection

@section('content')
@if (Auth::check())
<div class="attendance__panel">
    <div class="attendance__message">
        <p>{{ $user->name }}さん　お疲れ様です！</p>
    </div>
    <div class="attendance__button-group">
        <form class="attendance__button-workstart" action="/workin" method="post">
            @csrf
            <button class="attendance__button-submit" type="submit">勤務開始</button>
        </form>
        <form class="attendance__button-workstart" action="/workout" method="post">
            @csrf
            <button class="attendance__button-submit" type="submit">勤務終了</button>
        </form>
        <form class="attendance__button-breakstart" action="/breakin" method="post">
            @csrf
            <button class="attendance__button-submit" type="submit">休憩開始</button>
        </form>
        <form class="attendance__button-breakend" action="/breakout" method="post">
            @csrf
            <button class="attendance__button-submit" type="submit">休憩終了</button>
        </form>
        @if (session('flash_message'))
        <div class="flash_message">
            {{ session('flash_message') }}
        </div>
        @endif
    </div>
</div>
@endif
@endsection
