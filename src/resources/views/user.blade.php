@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('nav')
<nav>
    <ul class="header-nav">
        <li class="header-nav__item">
        <a class="header-nav__link" href="route{'index'}">ホーム</a>
        </li>
        <li class="header-nav__item">
            <a class="header-nav__link" href="route{'attendance'}">日付一覧</a>
            </li>
        <li class="header-nav__item">
            <form class="form" action="route{'logout'}" method="post">
                @csrf
            <button class="header-nav__button">ログアウト</button>
        </form>
        </li>
    </ul>
</nav>
@endsection

@section('content')
@if (Auth::check())

<div class="user__heading">
    <h2>{{ $userDataLists->first()->user->name }}さん 勤務データ</h2>
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
        @foreach ($userDataLists as $userDataList)
        <tr class="user__row">
            <td class="user__data">{{ $userDataList->created_at->format('Y-m-d') }}</td>
            <td class="user__data">{{ $userDataList->work_in }}</td>
            <td class="user__data">{{ $userDataList->work_out }}</td>
            <td class="user__data">{{ $userDataList->break_total }}</td>
            <td class="user__data">{{ $userDataList->working_time }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="user__pagination">
    {{-- {{ $userDataLists->links('vendor.pagination.custom') }} --}}
</div>
@endif
@endsection
