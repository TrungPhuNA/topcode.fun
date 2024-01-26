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
                <select class="form-control" name="service">
                    <option value="">--Chọn dịch vụ--</option>
                    <option value="vnpay" {{ Request::get('service') == 'vnpay' ? : '' }}>Vnpay</option>
                    <option value="momo" {{ Request::get('service') == 'momo' ? : '' }}>MoMo</option>
                </select>
            </div>
            <div class="form-group mb-2 mr-2">
                <label for="inputPassword2" class="sr-only">Mã KH</label>
                <input type="text" name="service_code" class="form-control" value="{{ Request::get('service_code') }}" placeholder="Service Code">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Find</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>ID</th>
                <th>Language</th>
                <th>PartnerCode</th>
                <th>Service</th>
                <th>IdentifierId</th>
                <th>Amount</th>
                <th>Create</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions ?? [] as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->language }}</td>
                    <td>{{ $item->partner_code }}</td>
                    <td>{{ $item->service }}</td>
                    <td>{{ $item->identifier_id }}</td>
                    <td>{{ number_format($item->amount,0,',','.') }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-12">
            {!! $transactions->appends($query ?? [])->links('vendor.pagination.bootstrap-4') !!}
        </div>
    </div>
@stop
