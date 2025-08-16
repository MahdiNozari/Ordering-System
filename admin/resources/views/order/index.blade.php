@extends('layout.master')
@section('title', 'Orders Page')

@section('content')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>آدرس</th>
                        <th>وضعیت</th>
                        <th>وضعیت پرداخت</th>
                        <th>قیمت کل</th>
                        <th>تاریخ</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <th>
                                {{ $order->id }}
                            </th>
                            <td>{{ $order->address->title }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <span
                                    class="{{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}">{{ $order->payment_status }}</span>
                            </td>
                            <td>{{ number_format($order->paying_amount) }} تومان</td>
                            <td>{{ verta($order->created_at)->format('%B %d، %Y') }}</td>

                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-{{ $order->id }}">
                                    محصولات
                                </button>

                                <div class="modal fade" id="modal-{{ $order->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">محصولات سفارش
                                                    شماره 25</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th>محصول</th>
                                                            <th>نام</th>
                                                            <th>قیمت</th>
                                                            <th>تعداد</th>
                                                            <th>قیمت کل</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->orderItems()->with('product')->get() as $item)
                                                            <tr>
                                                                <th>
                                                                    <img class="rounded" src="{{ ImageUrl($item->product->primary_image) }}"
                                                                        width="80" alt="" />
                                                                </th>
                                                                <td class="fw-bold">{{ $item->product->name }}</td>
                                                                <td>{{ number_format($item->price ) }} تومان</td>
                                                                <td>
                                                                    {{ $item->quantity }}
                                                                </td>
                                                                <td>{{ number_format($item->subtotal) }} تومان</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                            <a href="#" class="btn btn-sm btn-outline-info ms-2">ویرایش</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $orders->links('layout.paginate')}}
    </div>
@endsection