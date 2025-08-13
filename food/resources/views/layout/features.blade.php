@php
    $features = App\Models\Feature::all();
@endphp

<section class="card-area layout_padding">
        <div class="container">
            <div class="row gy-5">
                @foreach ($features as $feature)
                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="card-icon-wrapper">
                                <i class="bi {{ $feature->icon }} fs-2 text-white card-icon"></i>
                            </div>
                            <p class="card-text fw-bold">{{ $feature->title }}</p>
                            <p class="card-text">{{ $feature->body }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>