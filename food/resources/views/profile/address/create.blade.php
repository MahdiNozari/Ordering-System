@extends('profile.layout.master')
@section('title', 'Create Profile Page')

@section('script')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.data('cityInput', () => ({
                cities: @json($cities),
                citiesFilter:  [],
                province: 1,

                init() {
                    this.citiesFilter = this.cities.filter(city => city.province_id == this.province);

                    this.$watch('province', () => {
                        this.citiesFilter = this.cities.filter(city => city.province_id == this.province);
                    })
                }
            }))
        })
    </script>
@endsection

@section('main')
    <div x-data="cityInput" class="col-sm-12 col-lg-9">
        <h5 class="mb-4">
            ایجاد آدرس جدید
        </h5>

        <form action="{{ route('profile.address.store') }}" method="POST" class="card card-body">
            @csrf
            <div class="row g-4">
                <div class="col col-md-6">
                    <label class="form-label">عنوان</label>
                    <input name="title" type="text" class="form-control" />
                    <div class="form-text text-danger">
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">شماره تماس</label>
                    <input name="phone" type="text" class="form-control" />
                    <div class="form-text text-danger">
                        @error('phone')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">کد پستی</label>
                    <input name="postal_code" type="text" class="form-control" />
                    <div class="form-text text-danger">
                        @error('postal_code')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">استان</label>
                    <select x-model="province" name="province_id" class="form-select">
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text text-danger">
                        @error('province_id')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">شهر</label>
                    <select name="city_id" class="form-select">
                        <template x-for="city in citiesFilter" :key="city.id">
                            <option :value="city.id" x-text="city.name"></option>
                        </template>
                    </select>
                    <div class="form-text text-danger">
                        @error('city_id')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col col-md-12">
                    <label class="form-label">آدرس</label>
                    <textarea name="address" type="text" rows="5" class="form-control"></textarea>
                    <div class="form-text text-danger">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary mt-4">ایجاد</button>
            </div>
        </form>
    </div>
@endsection