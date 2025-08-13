@extends('layout.master')
@section('title', 'Footer')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">بخش فوتر</h4>

        <a href="{{ route('footer.edit', ['footer' => $footer->id]) }}" class="btn btn-sm btn-dark">ویرایش تنظیمات
            فوتر</a>
    </div>

    <form class="row gy-4">
        <div class="col-md-3">
            <label class="form-label">آدرس تماس با ما</label>
            <input disabled value="{{ $footer->contact_address }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">شماره تلفن تماس با ما</label>
            <input disabled value="{{ $footer->contact_phone }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">ایمیل تماس با ما</label>
            <input disabled value="{{ $footer->contact_email }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">عنوان</label>
            <input disabled value="{{ $footer->title }}" class="form-control" />
        </div>
        <div class="col-md-9">
            <label class="form-label">متن</label>
            <input disabled value="{{ $footer->body }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">روزهای کاری</label>
            <input disabled value="{{ $footer->work_days }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">ساعت شروع روز کاری</label>
            <input disabled value="{{ $footer->work_hour_from }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">ساعت پایان روز کاری</label>
            <input disabled value="{{ $footer->work_hour_to }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک تلگرام</label>
            <input disabled value="{{ $footer->telegram_link }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک واتس اپ</label>
            <input disabled value="{{ $footer->whatsapp_link }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک اینستاگرام</label>
            <input disabled value="{{ $footer->instagram_link }}" class="form-control" />
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک یوتیوب</label>
            <input disabled value="{{ $footer->youtube_link }}" class="form-control" />
        </div>
        <div class="col-md-6">
            <label class="form-label">متن کپی رایت </label>
            <input disabled value="{{ $footer->copyright }}" class="form-control" />
        </div>
    </form>
@endsection