@extends('layout.master')
@section('title', 'Payment Status')

@section('content')
<section class="auth_section "> 
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3 text-center">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            @if ($status)
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                            <h5 class="mt-3 text-success">پرداخت شما با موفقیت انجام شد شماره پیگیری: {{ $ref_id }}</h5>
                            @else   
                            <i class="bi bi-x-circle-fill text-danger fs-1"></i> 
                            <h5 class="mt-3 text-danger">پرداخت با خطا مواجه شد</h5>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            @if ($status)
                            <a href="{{ route('profile.order') }}" class="btn btn-primary">مشاهده سفارش</a>
                            @else
                            <a href="{{ route('cart.index') }}" class="btn btn-primary">سبد خرید</a>
                            @endif
                            <a href="{{ route('home') }}" class="btn btn-dark">بازگشت به سایت</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection