@extends('layout.master')
@section('title', 'Products')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">محصولات</h4>
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary">ایجاد محصول</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>تصویر</th>
                    <th>نام</th>
                    <th>دسته بندی</th>
                    <th>قیمت</th>
                    <th>تعداد</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset('images/products/' . $product->primary_image) }}" class="rounded" width="100" alt="product-image">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ number_format($product->price) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->status ? 'فعال' : 'غیر فعال' }}</td>

                        <td>
                            <div class="d-flex">
                                <a href="{{ route('products.show', ['product' => $product->id]) }}"
                                    class="btn btn-sm btn-outline-primary me-2">نمایش</a>

                                <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                    class="btn btn-sm btn-outline-info me-2">ویرایش</a>

                                <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $products->links('layout.paginate') }}
        </div>
    </div>
@endsection