@extends('layouts.app_admin')

@section('css')

<link rel="stylesheet" href="{{ asset('css/user.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin_user.css') }}">

@endsection

@section('header_admin')
@include('layouts.header_nav_admin')
@endsection

@section('content')
<div class="user__heading">
    <div class="user__heading-title">
        <h2>{{ $id->name }}さん 勤務データ</h2>
    </div>
    <div class="user__heading-nav">
        <form class="user__button" action="/admin/user/{{$id->id}}" method="get">
            <button class="user__button-submit" name="date" value="{{ $lastMonth }}" type="submit" > &lt;
            </button>
        </form>
        <p class="user__date-thisMonth">
            {{ $thisMonth->format('Y/m') }}
        </p>
        <form class="user__button" action="/admin/user/{{$id->id}}" method="get" >
            <button class="user__button-submit" name="date" value="{{ $nextMonth }}" type="submit" > &gt;</button>
        </form>
    </div>
</div>

<div class="user__inner">
    <table class="user__table">
        <tr class="user__table--contents">
            <th class="user__table--contents-data">勤務日</th>
            <th class="user__table--contents-data">勤務開始</th>
            <th class="user__table--contents-data">勤務終了</th>
            <th class="user__table--contents-data">休憩時間</th>
            <th class="user__table--contents-data">勤務時間</th>
            <th class="user__table--contents-data-modal"></th>
        </tr>
        @foreach ($thisMonthLists as $thisMonthList)
        <tr class="user__table--contents">
            <td class="user__table--contents-data">{{ $thisMonthList->created_at->format('m/d') }}</td>
            <td class="user__table--contents-data">{{ $thisMonthList->work_in }}</td>
            <td class="user__table--contents-data">{{ $thisMonthList->work_out }}</td>
            <td class="user__table--contents-data">{{ $thisMonthList->break_total }}</td>
            <td class="user__table--contents-data">{{ $thisMonthList->working_time }}</td>
            <td class="user__table--contents-data-modal">
                <div class="user__table--contents-data__button">
                    <label for="modal-toggle-{{ $thisMonthList['id'] }}" class="user__table--contents-data__button-submit">詳細</label>
                </div>
                <input type="checkbox" id="modal-toggle-{{ $thisMonthList['id'] }}" class="modal-toggle">
                <div class="modal">
                    <label class="close__button-submit" for="modal-toggle-{{ $thisMonthList['id'] }}"></label>
                    <div class="detail-table">
                        <form class="detail-table__form" action="{{ route('updateTime') }}" method="post">
                            @method('PATCH')
                            @csrf
                            <table class="detail-table__inner">
                                <tr class="detail-table__contents">
                                    <th class="detail-table__contents--data">勤務日</th>
                                    <td class="detail-table__contents--data">
                                        {{ $thisMonthList->created_at->format('Y/m/d') }}
                                    </td>
                                </tr>
                                <tr class="detail-table__contents">
                                    <th class="detail-table__contents--data">勤務開始</th>
                                    <td class="detail-table__contents--data">
                                        <input type="time" name="work_in" value="{{ $thisMonthList->work_in }}" />
                                    </td>
                                </tr>
                                <tr class="detail-table__contents">
                                    <th class="detail-table__contents--data">勤務終了</th>
                                    <td class="detail-table__contents--data">
                                        <input type="time" name="work_out" value="{{ $thisMonthList->work_out }}" />
                                    </td>
                                </tr>
                            </table>
                            <div class="detail-table__form-button">
                                <input type="hidden" name="id" value="{{ $thisMonthList->id }}">
                                <button class="detail-table__form-button-submit" type="submit">修正</button>
                            </div>
                        </form>
                        @foreach ($thisMonthBreakLists[$thisMonthList->id] as $breakList)
                        <form class="detail-table__form" action="{{route('updateBreak')}}" method="post">
                            @method('PATCH')
                            @csrf
                            <table class="detail-table__inner">
                                <tr class="detail-table__contents">
                                    <th class="detail-table__contents--data">休憩開始</th>
                                    <td class="detail-table__contents--data">
                                        <input type="time" name="break_in" value="{{ $breakList->break_in }}" />
                                    </td>
                                </tr>
                                <tr class="detail-table__contents">
                                    <th class="detail-table__contents--data">休憩終了</th>
                                    <td class="detail-table__contents--data">
                                        <input type="time" name="break_out" value="{{ $breakList->break_out }}" />
                                    </td>
                                </tr>
                            </table>
                            <div class="detail-table__form-button">
                                <input type="hidden" name="id" value="{{ $breakList->id }}">
                                <input type="hidden" name="timestamp_id" value="{{ $thisMonthList->id }}">
                                <button class="detail-table__form-button-submit" type="submit">修正</button>
                            </div>
                        </form>
                        @endforeach
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
</div>
<div class="user__pagination">
    {{ $thisMonthLists->links('vendor.pagination.custom') }}
</div>
@if (session('flash_message'))
        <div class="flash_message">
            {{ session('flash_message') }}
        </div>
@endif
@endsection
