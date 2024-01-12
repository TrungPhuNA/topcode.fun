@extends('layout.app_payment')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Danh sách thanh toán</h2>
        <a href="/payment/create">Thêm mới</a>
    </div>
    <div>
        <form class="form-inline">
            <div class="form-group mb-2 mr-2">
                <label for="inputPassword2" class="sr-only">Service</label>
                <input type="text" name="service" class="form-control" value="{{ Request::get('service') }}" placeholder="Mã Service">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Find</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th style="width: 120px;text-align: center">Service</th>
                <th style="width: 120px;text-align: center">Code</th>
                <th>txnref</th>
{{--                <th>transaction_no</th>--}}
                <th>note</th>
{{--                <th>card_type</th>--}}
{{--                <th>bank_code</th>--}}
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments ?? [] as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td style="text-align: center">{{ $item->service_code }}</td>
                    <td style="text-align: center">{{ $item->tmn_code }}</td>
                    <td>{{ $item->txnref }}</td>
{{--                    <td>{{ $item->transaction_no }}</td>--}}
                    <td>{{ $item->note }}</td>
{{--                    <td>{{ $item->card_type }}</td>--}}
{{--                    <td>{{ $item->bank_code }}</td>--}}
                    <td>{{ number_format($item->amount,0,',','.') }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-12">
            {!! $payments->appends($query ?? [])->links('vendor.pagination.bootstrap-4') !!}
        </div>
    </div>
@stop
