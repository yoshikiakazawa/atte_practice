@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('header')
@include('layouts.header_nav')
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
        {{ $today->format('Y/m/d') }}
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
            <td class="confirmation__data">{{ $todayList->break_total }}</td>
            <td class="confirmation__data">{{ $todayList->working_time }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="confirmation__pagination">
    {{ $todayLists->links('vendor.pagination.custom') }}
</div>
@endif
@endsection
