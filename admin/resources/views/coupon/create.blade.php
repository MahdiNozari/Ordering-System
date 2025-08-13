@extends('layout.master')
@section('title', 'Coupon Create')

@section('link')
    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
    <script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
@endsection

@section('script')
    <script type="text/javascript">
        jalaliDatepicker.startWatch({
            time: true
        });
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ایجاد کد تخفیف</h4>
    </div>

    <form action="{{ route('coupons.store') }}" method="POST" class="row gy-4">
        @csrf
        <div class="col-md-3">
            <label class="form-label">کد</label>
            <input name="code" value="{{ old('code') }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('code')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">درصد تخفیف</label>
            <input name="percentage" value="{{ old('percentage') }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('percentage')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ انقضا</label>
            <input data-jdp name="expired_at" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('expired_at')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ایجاد کد تخفیف
            </button>
        </div>
    </form>
@endsection