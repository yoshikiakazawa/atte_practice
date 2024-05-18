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
            {{ $thisMonth->format('Y/m') }}
        </p>
        <form class="user__button" action="/user/{{$id->id}}" method="get" >
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
                                    {{ $thisMonthList->work_in }}
                                </td>
                            </tr>
                            <tr class="detail-table__contents">
                                <th class="detail-table__contents--data">勤務終了</th>
                                <td class="detail-table__contents--data">
                                    {{ $thisMonthList->work_out }}
                                </td>
                            </tr>
                        </table>
                        @foreach ($thisMonthBreakLists[$thisMonthList->id] as $breakList)
                        <table class="detail-table__inner">
                            <tr class="detail-table__contents">
                                <th class="detail-table__contents--data">休憩開始</th>
                                <td class="detail-table__contents--data">
                                    {{ $breakList->break_in }}
                                </td>
                            </tr>
                            <tr class="detail-table__contents">
                                <th class="detail-table__contents--data">休憩終了</th>
                                <td class="detail-table__contents--data">
                                    {{ $breakList->break_out }}
                                </td>
                            </tr>
                        </table>
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
@endif
@endsection
