@extends('layout.master')
@section('title', 'Transaction Page')

@section('content')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>مبلغ</th>
                        <th>وضعیت</th>
                        <th>شماره پیگیری</th>
                        <th>تاریخ</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <th>
                                {{ $transaction->id }}
                            </th>
                            <td>{{ number_format($transaction->amount) }} تومان</td>
                            <td>
                                <span class="{{ $transaction->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">{{ $transaction->status }}</span>
                            </td>
                            <td>{{ $transaction->ref_number }}</td>
                            <td>{{ verta($transaction->created_at)->format('%B %d، %Y') }}</td>
                             <td>
                            <a href="#" class="btn btn-sm btn-outline-info ms-2">ویرایش</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $transactions->links('layout.paginate') }}
    </div>
@endsection