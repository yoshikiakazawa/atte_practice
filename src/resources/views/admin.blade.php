@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header')
@include('layouts.header_nav')
@endsection

@section('content')
@if (Auth::check())

<div class="admin__heading">
    <h2 class="admin__heading-title">user一覧</h2>
</div>
<div class="admin__inner">
    <table class="admin__table">
        <tr class="admin__row">
            <th class="admin__label">ID</th>
            <th class="admin__label">お名前</th>
            <th class="admin__label">E-mail</th>
            <th class="admin__label"></th>
            <th class="admin__label">登録日</th>
        </tr>
        @foreach ($users as $user)
        <tr class="admin__row">
            <td class="admin__data">{{ $user->id }}</td>
            <td class="admin__data">{{ $user->name }}</td>
            <td class="admin__data">{{ $user->email }}</td>
            <td class="admin__data"><a class="btn" href="{{ route('user',$user->id) }}">詳細</a></td>
            <td class="admin__data">{{ $user->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="admin__pagination">
    {{ $users->links('vendor.pagination.custom') }}
</div>
@endif
@endsection
