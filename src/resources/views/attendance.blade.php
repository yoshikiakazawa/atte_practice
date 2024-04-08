@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
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
{{-- @foreach ($groups as $date => $group) --}}
{{-- @if ($date = "2024-04-04") --}}
<div class="confirmation__heading">
    <h2>{{ "2024-04-05" }}</h2>
</div>
<div class="confirmation__inner">
    {{-- @foreach ($groups as $date => $group) --}}
    {{-- <h3>{{ $date }}</h3> --}}
    <table class="confirmation__table">
        <tr class="confirmation__row">
            <th class="confirmation__label">名前</th>
            <th class="confirmation__label">勤務開始</th>
            <th class="confirmation__label">勤務終了</th>
            <th class="confirmation__label">休憩時間</th>
            <th class="confirmation__label">勤務時間</th>
        </tr>
        @foreach ($times as $time)
        {{-- @if ($time->created_at == "2024-04-05 00:00:00") --}}

        <tr class="confirmation__row">
            <td class="confirmation__data">{{ $time->user->name }}</td>
            <td class="confirmation__data">{{ $time->workIn }}</td>
            <td class="confirmation__data">{{ $time->workOut }}</td>
            <td class="confirmation__data">{{ $time->breakTime }}</td>
            <td class="confirmation__data">{{ $time->workingtime }}</td>
        </tr>
        {{-- @endif --}}
        @endforeach
    </table>
    {{-- @endforeach --}}
    {{ $times->links('vendor.pagination.custom') }}
</div>
{{-- @endforeach --}}

{{-- {{ $times->links('vendor.pagination.custom') }} --}}
@endif
@endsection
