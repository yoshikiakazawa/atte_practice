@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header_admin')
@include('layouts.header_nav_admin')
@endsection

@section('content')

<div class="admin__heading">
    <h2 class="admin__heading-title">user一覧</h2>
</div>
<div class="admin__inner">
    <table class="admin__table">
        <tr class="admin__table--contents">
            <th class="admin__table--contents--data">ID</th>
            <th class="admin__table--contents--data">お名前</th>
            <th class="admin__table--contents--data-email">E-mail</th>
            <th class="admin__table--contents--data"></th>
            <th class="admin__table--contents--data">登録日</th>
        </tr>
        @foreach ($users as $user)
        <tr class="admin__table--contents">
            <td class="admin__table--contents--data">{{ $user->id }}</td>
            <td class="admin__table--contents--data">{{ $user->name }}</td>
            <td class="admin__table--contents--data-email">{{ $user->email }}</td>
            <td class="admin__table--contents--data">
                <a class="admin__table--contents--data-btn" href="{{ route('admin_user',$user->id) }}">詳細</a>
            </td>
            <td class="admin__table--contents--data">{{ $user->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="admin__pagination">
    {{ $users->links('vendor.pagination.custom') }}
</div>
@endsection
