@extends('layout.master')
@section('title', 'Category')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">کاربران</h4>
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-primary">ایجاد کاربر</a>
            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-dark">نقش ها</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>شماره تلفن</th>
                    <th>ایمیل</th>
                    <th>نقش ها</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->implode('name',',') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-info me-2">ویرایش</a>
                            
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection