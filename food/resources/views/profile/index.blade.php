@extends('profile.layout.master')

@section('main')
    <div class="col-sm-12 col-lg-9">
                <form action="{{ route('profile.update',$user->id) }}" method="POST" class="vh-70">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col col-md-6">
                                <label class="form-label">نام و نام خانوادگی</label>
                                <input name="name" type="text" class="form-control" value="{{ $user->name }}" />
                                <div class="form-text text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <label class="form-label">ایمیل</label>
                                <input name="email" type="text" class="form-control" value="{{ $user->email }}" />
                                <div class="form-text text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <label class="form-label">شماره تلفن</label>
                                <input name="phone" type="text" disabled class="form-control" value="{{ $user->phone }}" />
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary mt-4">ویرایش</button>
                </form>
    </div>
@endsection