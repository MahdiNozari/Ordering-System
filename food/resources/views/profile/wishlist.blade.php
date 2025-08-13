@extends('profile.layout.master')
@section('title', 'Profile Page')

@section('main')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>محصول</th>
                        <th>نام</th>
                        <th>قیمت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wishlist as $item)
                        <tr>
                            <th>
                                <img class="rounded" src="{{ imageUrl($item->product->primary_image) }}" width="100"
                                    alt="" />
                            </th>
                            <td class="fw-bold">
                                <a href="{{ route('products.show', ['product' => $item->product->slug]) }}">
                                    {{ $item->product->name }}
                                </a>
                            </td>
                            <td>
                                @if ($item->product->is_sale)
                                    <div>
                                        <del>{{ number_format($item->product->price) }}</del>
                                        {{ number_format($item->product->sale_price) }}
                                        تومان
                                    </div>
                                    <div class="text-danger">
                                        {{ salePercent($item->product->price, $item->product->sale_price) }}%
                                        تخفیف
                                    </div>
                                @else
                                    <div>
                                        {{ number_format($item->product->price) }}
                                        تومان
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('profile.wishlist.remove', ['wishlist' => $item->id]) }}"
                                    class="btn btn-primary">
                                    حذف
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection