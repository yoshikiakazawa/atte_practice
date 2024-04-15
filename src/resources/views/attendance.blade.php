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

<div class="confirmation__heading">
    <form class="confirmation__button" action="/attendance" method="get">
        @csrf
        <button class="confirmation__button-submit" name="date" value="{{ $yesterday }}" type="submit" > &lt;
        </button>
    </form>
    <p class="confirmation__date-today">
        {{ $today->format('Y-m-d') }}
    </p>
    <form class="confirmation__button" action="/attendance" method="get" >
        @csrf
        <button class="confirmation__button-submit" name="date" value="{{ $tomorrow }}" type="submit" > &gt;</button>
    </form>
</div>
<div class="confirmation__inner">
    <table class="confirmation__table">
        <tr class="confirmation__row">
            <th class="confirmation__label">名前</th>
            <th class="confirmation__label">勤務開始</th>
            <th class="confirmation__label">勤務終了</th>
            <th class="confirmation__label">休憩時間</th>
            <th class="confirmation__label">勤務時間</th>
        </tr>
        @foreach ($todayLists as $todayList)
        <tr class="confirmation__row">
            <td class="confirmation__data">{{ $todayList->user->name }}</td>
            <td class="confirmation__data">{{ $todayList->work_in }}</td>
            <td class="confirmation__data">{{ $todayList->work_out }}</td>
            @php
            $breakTime = null;
            $workAndBreakTime = null;
            foreach ($breakTimes as $bt) {
                if ($bt['timestamp_id'] == $todayList->id) {
                    $breakTime = $bt;
                    break;
                }
            }
            foreach ($workAndBreakTimes as $wabt) {
                if ($wabt['timestamp_id'] == $todayList->id) {
                    $workAndBreakTime = $wabt;
                    break;
                }
            }
            @endphp
            <td class="confirmation__data">{{ $breakTime ? gmdate('H:i:s', $breakTime['total_break_time']) : '' }}</td>
            <td class="confirmation__data">{{ $workAndBreakTime ? gmdate('H:i:s', $workAndBreakTime['total_work_time']) : '' }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="confirmation__pagination">
    {{ $todayLists->links('vendor.pagination.custom') }}
</div>
@endif
@endsection