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
        <p><a class="attendance__message-btn" href="{{ route('user',$user->id) }}">{{ $user->name }}</a>さん　お疲れ様です！</p>
    </div>
    <div class="attendance__button-group">
        @if($judFirst)
        <form class="attendance__button" action="{{ route('workIn') }}" method="post">
            @csrf
            <button class="attendance__button-submit" type="submit">勤務開始</button>
        </form>
        <button class="attendance__button-submit-error" type="submit">勤務終了</button>
        <button class="attendance__button-submit-error" type="submit">休憩開始</button>
        <button class="attendance__button-submit-error" type="submit">休憩終了</button>
        @else
            @if($judWorkIn)
            <button class="attendance__button-submit-error" type="submit">勤務開始</button>
            @else
            <form class="attendance__button" action="{{ route('workIn') }}" method="post">
                @csrf
                <button class="attendance__button-submit" type="submit">勤務開始</button>
            </form>
            @endif
            @if($judOut)
            <form class="attendance__button" action="{{ route('workOut') }}" method="post">
                @csrf
                <button class="attendance__button-submit" type="submit">勤務終了</button>
            </form>
            @else
            <button class="attendance__button-submit-error" type="submit">勤務終了</button>
            @endif
            @if($judOut)
            <form class="attendance__button" action="{{ route('breakIn') }}" method="post">
                @csrf
                <button class="attendance__button-submit" type="submit">休憩開始</button>
            </form>
            @else
            <button class="attendance__button-submit-error" type="submit">休憩開始</button>
            @endif
            @if($judBreakOut)
            <form class="attendance__button" action="{{ route('breakOut') }}" method="post">
                @csrf
                <button class="attendance__button-submit" type="submit">休憩終了</button>
            </form>
            @else
            <button class="attendance__button-submit-error" type="submit">休憩終了</button>
            @endif
        @endif

        @if (session('flash_message'))
        <div class="flash_message">
            {{ session('flash_message') }}
        </div>
        @endif
    </div>
</div>
@endif
@endsection
