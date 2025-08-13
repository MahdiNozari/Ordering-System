@extends('layout.master')
@section('title', 'Show Product Page')

@section('content')

    <section class="single_page_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row gy-5">
                        <div class="col-sm-12 col-lg-6">
                            <h3 class="fw-bold mb-4">{{ $product->name }}</h3>

                            @if ($product->is_sale)
                                <h5 class="mb-3">
                                    <del>{{ number_format($product->price) }}</del>
                                    {{ number_format($product->sale_price) }}
                                    تومان
                                    <div class="text-danger fs-6">
                                        {{ salePercent($product->price, $product->sale_price) }}% تخفیف
                                    </div>
                                </h5>
                            @else
                                <h5>
                                    {{ number_format($product->price) }}
                                    تومان
                                </h5>
                            @endif

                            <p>{{ $product->description }}</p>

                            <form x-data="{ quantity: 1 }" action="{{ route('cart.add') }}" class="mt-5 d-flex">
                                <button class="btn-add">افزودن به سبد خرید</button>

                                <input name="product_id" value="{{ $product->id }}" type="hidden">
                                <input name="qty" :value="quantity" type="hidden">

                                <div class="input-counter ms-4">
                                    <span @click="quantity < {{ $product->quantity }} && quantity++" class="plus-btn">
                                        +
                                    </span>
                                    <div class="input-number" x-text="quantity"></div>
                                    <span @click="quantity > 1 && quantity--" class="minus-btn">
                                        -
                                    </span>
                                </div>
                            </form>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                        class="active">
                                    </button>

                                    @foreach ($product->images as $key => $image)
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="{{ $key + 1 }}"></button>
                                    @endforeach
                                </div>

                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ imageUrl($product->primary_image) }}" class="d-block w-100"
                                            alt="primary_image" />
                                    </div>

                                    @foreach ($product->images as $image)
                                        <div class="carousel-item">
                                            <img src="{{ imageUrl($image->image) }}" class="d-block w-100" alt="image" />
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr>

    <section class="food_section my-5">
        <div class="container">
            <div class="row gx-3">
                @foreach ($randomProduct as $product)
                    <div class="col-sm-6 col-lg-3">
                        <div class="box">
                            <div>
                                <div class="img-box">
                                    <img class="img-fluid" src="{{ imageUrl($product->primary_image) }}" alt="">
                                </div>
                                <div class="detail-box">
                                    <h5>
                                        <a href="{{ route('products.show', ['product' => $product->slug]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h5>
                                    <p>
                                        {{ $product->description }}
                                    </p>

                                    <div class="options">
                                        @if ($product->is_sale)
                                            <h6>
                                                <del>{{ number_format($product->price) }}</del>
                                                <span>
                                                    <span
                                                        class="text-danger">({{ salePercent($product->price, $product->sale_price) }}%)</span>
                                                    {{ number_format($product->sale_price) }}
                                                    <span>تومان</span>
                                                </span>
                                            </h6>
                                        @else
                                            <h6>
                                                {{ number_format($product->price) }}
                                                <span>تومان</span>
                                            </h6>
                                        @endif

                                        <div class="d-flex">
                                            <a class="me-2" href="{{ route('cart.increment', ['product_id' => $product->id, 'qty' => 1]) }}">
                                                <i class="bi bi-cart-fill text-white fs-6"></i>
                                            </a>
                                            <a href="{{ route('profile.addtowishlist', ['product_id' => $product->id ]) }}">
                                                <i class="bi bi-heart-fill text-white fs-6"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection