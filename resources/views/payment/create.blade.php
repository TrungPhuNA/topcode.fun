@extends('layout.app_payment')
@section('content')
    <div class="table-responsive">
        <form action="" id="frmCreateOrder" method="post">
            @csrf
            <div class="form-group">
                <label for="amount">Số tiền</label>
                <input class="form-control" data-val="true" data-val-number="The field Amount must be a number." data-val-required="The Amount field is required." id="amount" max="100000000" min="1" name="amount" type="number" value="10000" />
            </div>
            <h4>Chọn phương thức thanh toán</h4>
            <div class="form-group">
                <h5>QR Code Hoạc Chuyển Khoản</h5>
                <input type="radio" Checked="True" id="bankCode" name="bankCode" value="">
                <label for="bankCode">Cổng thanh toán QR CODE</label><br>
                <input type="radio"  id="bankCode" name="bankCode" value="payWithATM">
                <label for="bankCode">Chuyển quản</label><br>

{{--                <h5>Cách 2: Tách phương thức tại site của đơn vị kết nối</h5>--}}
{{--                <input type="radio" id="bankCode" name="bankCode" value="VNPAYQR">--}}
{{--                <label for="bankCode">Thanh toán bằng ứng dụng hỗ trợ VNPAYQR</label><br>--}}

{{--                <input type="radio" id="bankCode" name="bankCode" value="VNBANK">--}}
{{--                <label for="bankCode">Thanh toán qua thẻ ATM/Tài khoản nội địa</label><br>--}}

{{--                <input type="radio" id="bankCode" name="bankCode" value="INTCARD">--}}
{{--                <label for="bankCode">Thanh toán qua thẻ quốc tế</label><br>--}}

            </div>
            <div class="form-group">
                <h5>Chọn ngôn ngữ giao diện thanh toán:</h5>
                <input type="radio" id="language" Checked="True" name="language" value="vn">
                <label for="language">Tiếng việt</label><br>
                <input type="radio" id="language" name="language" value="en">
                <label for="language">Tiếng anh</label><br>
            </div>
            <div class="form-group">
                <h5>Loại service:</h5>
                <input type="radio"  checked name="service" value="vnpay">
                <label for="language">VNPAY</label><br>
                <input type="radio"  name="service" value="nganluong">
                <label for="language">Ngân Lượng</label><br>
                <input type="radio"  name="service" value="momo">
                <label for="language">Momo</label><br>
            </div>
            <button type="submit" class="btn btn-default" href>Thanh toán</button>
        </form>
    </div>
@stop
