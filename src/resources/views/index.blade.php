@extends('layouts.app')

@section('nav')
<nav>
    <ul class="header-nav">
        <li class="header-nav__item">
        <a class="header-nav__link" href="/mypage">ホーム</a>
        </li>
        <li class="header-nav__item">
            <a class="header-nav__link" href="/mypage">日付一覧</a>
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

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
@if (Auth::check())

<div class="attendance__content">
    <div class="attendance__panel">
        <div class="attendance__message">
            <p>{{ $user->name }}さん　お疲れ様です！</p>
        </div>
        <div class="attendance__button-group">
            <form class="attendance__button-workstart" action="/start" method="post">
                @csrf
            <button class="attendance__button-submit" type="submit">勤務開始</button>
            </form>
            <form class="attendance__button-workend">
            <button class="attendance__button-submit" type="submit">勤務終了</button>
            </form>
            <form class="attendance__button-breakstart">
                <button class="attendance__button-submit" type="submit">休憩開始</button>
            </form>
            <form class="attendance__button-breakend">
                <button class="attendance__button-submit" type="submit">休憩終了</button>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
