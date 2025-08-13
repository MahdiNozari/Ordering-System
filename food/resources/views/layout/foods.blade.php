    <section class="food_section layout_padding-bottom">
        <div class="container" x-data="{ tab: 1 }">
            <div class="heading_container heading_center">
                <h2>
                    منو محصولات
                </h2>
            </div>

            <ul class="filters_menu">
                <li :class="tab === 1 ? 'active' : ''" @click="tab = 1">برگر</li>
                <li :class="tab === 2 ? 'active' : ''" @click="tab = 2">پیتزا</li>
                <li :class="tab === 3 ? 'active' : ''" @click="tab = 3">پیش غذا و سالاد</li>
            </ul>

            @php
                $burgers = App\Models\Product::where('category_id',6)->where('quantity','>',0)->where('status',1)->take(3)->get();
                $pizzas = App\Models\Product::where('category_id',5)->where('quantity','>',0)->where('status',1)->take(3)->get();
                $salads = App\Models\Product::where('category_id',7)->where('quantity','>',0)->where('status',1)->take(3)->get();
                $drinks = App\Models\Product::where('category_id',8)->where('quantity','>',0)->where('status',1)->take(3)->get();
            @endphp
            
            <div class="filters-content">
                <div x-show="tab === 1">
                    <div class="row grid">
                        @foreach ($burgers as $burger)
                            <div class="col-sm-6 col-lg-4">
                            <div class="box">
                                <div>
                                    <div class="img-box">
                                        <img class="img-fluid" src="{{ ImageUrl($burger->primary_image) }}" alt="">
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            <a href="{{ route('products.show',$burger->slug) }}">
                                            {{ $burger->name }}
                                            </a>
                                        </h5>
                                        <p>
                                            {{ $burger->description }}
                                        </p>
                                        <div class="options">
                                            @if($burger->is_sale)
                                            <h6>
                                                <del>{{ number_format($burger->price) }}</del>
                                                <span>
                                                    <span class="text-danger">{{ SalePercent($burger->price,$burger->sale_price) }}%</span>
                                                    {{ number_format($burger->sale_price) }}
                                                    <span>تومان</span>
                                                </span>
                                            </h6>
                                            @else
                                            <h6>
                                                {{ number_format($burger->price) }}
                                                <span>تومان</span>
                            
                                            </h6>
                                            @endif
                                            <div class="d-flex">
                                                <a class="me-2" href="{{ route('cart.increment',['product_id' => $burger->id, 'qty' =>1]) }}">
                                                    <i class="bi bi-cart-fill text-white fs-6"></i>
                                                </a>
                                                <a href="{{ route('profile.addtowishlist',['product_id'=>$burger->id]) }}">
                                                    <i class="bi bi-heart-fill  text-white fs-6"></i>
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
                        
                <div x-show="tab === 2">
                    <div class="row grid">
                        
                        @foreach ($pizzas as $pizza)
                            <div class="col-sm-6 col-lg-4">
                            <div class="box">
                                <div>
                                    <div class="img-box">
                                        <img class="img-fluid" src="{{ ImageUrl($pizza->primary_image) }}" alt="">
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            <a href="{{ route('products.show',$pizza->slug) }}">
                                            {{ $pizza->name }}
                                            </a>
                                        </h5>
                                        <p>
                                            {{ $pizza->description }}
                                        </p>
                                        <div class="options">
                                            @if($pizza->is_sale)
                                            <h6>
                                                <del>{{ number_format($pizza->price) }}</del>
                                                <span>
                                                    <span class="text-danger">{{ SalePercent($pizza->price,$pizza->sale_price) }}%</span>
                                                    {{ number_format($pizza->sale_price) }}
                                                    <span>تومان</span>
                                                </span>
                                            </h6>
                                            @else
                                            <h6>
                                                {{ number_format($pizza->price) }}
                                                <span>تومان</span>
                            
                                            </h6>
                                            @endif
                                            <div class="d-flex">
                                                <a class="me-2" href="{{ route('cart.increment',['product_id' => $pizza->id, 'qty' =>1]) }}">
                                                    <i class="bi bi-cart-fill text-white fs-6"></i>
                                                </a>
                                                <a href="{{ route('profile.addtowishlist',['product_id'=>$pizza->id]) }}">
                                                    <i class="bi bi-heart-fill  text-white fs-6"></i>
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

                <div x-show="tab === 3">
                    <div class="row grid">
                        @foreach ($salads as $salad)
                            <div class="col-sm-6 col-lg-4">
                            <div class="box">
                                <div>
                                    <div class="img-box">
                                        <img class="img-fluid" src="{{ ImageUrl($salad->primary_image) }}" alt="">
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            <a href="{{ route('products.show',$salad->slug) }}">
                                            {{ $salad->name }}
                                            </a>
                                        </h5>
                                        <p>
                                            {{ $salad->description }}
                                        </p>
                                        <div class="options">
                                            @if($salad->is_sale)
                                            <h6>
                                                <del>{{ number_format($salad->price) }}</del>
                                                <span>
                                                    <span class="text-danger">{{ SalePercent($salad->price,$salad->sale_price) }}%</span>
                                                    {{ number_format($salad->sale_price) }}
                                                    <span>تومان</span>
                                                </span>
                                            </h6>
                                            @else
                                            <h6>
                                                {{ number_format($salad->price) }}
                                                <span>تومان</span>
                            
                                            </h6>
                                            @endif
                                            <div class="d-flex">
                                                <a class="me-2" href="{{ route('cart.increment',['product_id' => $salad->id, 'qty' =>1]) }}">
                                                    <i class="bi bi-cart-fill text-white fs-6"></i>
                                                </a>
                                                <a href="{{ route('profile.addtowishlist',['product_id'=>$salad->id]) }}">
                                                    <i class="bi bi-heart-fill  text-white fs-6"></i>
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

            </div>

            <div class="btn-box">
                <a href="">
                    مشاهده بیشتر
                </a>
            </div>
        </div>
    </section>