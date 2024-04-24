@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
@include('layouts.header_nav')
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
