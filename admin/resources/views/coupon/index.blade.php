@extends('layout.master')
@section('title', 'Coupons')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">کدهای تخفیف</h4>
        <a href="{{ route('coupons.create') }}" class="btn btn-sm btn-outline-primary">ایجاد کد تخفیف</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>کد</th>
                    <th>درصد</th>
                    <th>انقضا</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->percentage }}</td>
                    <td>{{ verta($coupon->expired_at)->formatjalalidate() }}</td>

                    <td>
                        <div class="d-flex">
                            <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-info me-2">ویرایش</a>
                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST">
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