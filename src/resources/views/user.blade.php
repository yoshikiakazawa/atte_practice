@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('header')
@include('layouts.header_nav')
@endsection

@section('content')
@if (Auth::check())
<div class="user__heading">
    <div class="user__heading-title">
        <h2>{{ $id->name }}さん 勤務データ</h2>
    </div>
    <div class="user__heading-nav">
        <form class="user__button" action="/user/{{$id->id}}" method="get">
            <button class="user__button-submit" name="date" value="{{ $lastMonth }}" type="submit" > &lt;
            </button>
        </form>
        <p class="user__date-thisMonth">
            {{ $thisMonth->format('Y-m') }}
        </p>
        <form class="user__button" action="/user/{{$id->id}}" method="get" >
            <button class="user__button-submit" name="date" value="{{ $nextMonth }}" type="submit" > &gt;</button>
        </form>
    </div>
</div>

<div class="user__inner">
    <table class="user__table">
        <tr class="user__row">
            <th class="user__label">勤務日</th>
            <th class="user__label">勤務開始</th>
            <th class="user__label">勤務終了</th>
            <th class="user__label">休憩時間</th>
            <th class="user__label">勤務時間</th>
        </tr>
        @foreach ($thisMonthLists as $thisMonthList)
        <tr class="user__row">
            <td class="user__data">{{ $thisMonthList->created_at->format('Y-m-d') }}</td>
            <td class="user__data">{{ $thisMonthList->work_in }}</td>
            <td class="user__data">{{ $thisMonthList->work_out }}</td>
            <td class="user__data">{{ $thisMonthList->break_total }}</td>
            <td class="user__data">{{ $thisMonthList->working_time }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="user__pagination">
    {{ $thisMonthLists->links('vendor.pagination.custom') }}
</div>
@endif
@endsection
