@extends('profile.layout.master')

@section('title', 'Profile Page')

@section('main')
     <div class="col-sm-12 col-lg-9">
                    <a href="{{ route('profile.address.create') }}" class="btn btn-primary mb-4">
                        ایجاد آدرس جدید
                    </a>
                @foreach ($addresses as $address)
                    <div class="card card-body">
                        <div class="row g-4">
                            <div class="col col-md-6">
                                <label class="form-label">عنوان</label>
                                <input disabled type="text" value="{{ $address->title }}" class="form-control" />
                            </div>
                            <div class="col col-md-6">
                                <label class="form-label">شماره تماس</label>
                                <input disabled type="text" value="{{ $address->phone }}" class="form-control" />
                            </div>
                            <div class="col col-md-6">
                                <label class="form-label">کد پستی</label>
                                <input disabled type="text" value="{{ $address->postal_code }}" class="form-control" />
                            </div>
                            <div class="col col-md-6">
                                <label class="form-label">استان</label>
                                <input disabled type="text" value="{{ $address->province->name }}" class="form-control" />
                            </div>
                            <div class="col col-md-6">
                                <label class="form-label">شهر</label>
                                <input disabled type="text" value="{{ $address->city->name }}" class="form-control" />
                            </div>
                            <div class="col col-md-12">
                                <label class="form-label">آدرس</label>
                                <textarea disabled type="text" rows="5"
                                    class="form-control">{{ $address->address }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('profile.address.edit',$address->id) }}" class="btn btn-primary">ویرایش</a>
                        </div>
                    </div>
                    <hr/>
                @endforeach
                </div>
@endsection