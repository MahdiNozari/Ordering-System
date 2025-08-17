@extends('layout.master')
@section('title', 'User')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">نقش ها</h4>
        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-outline-primary">ایجاد نقش </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-info me-2">ویرایش</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection