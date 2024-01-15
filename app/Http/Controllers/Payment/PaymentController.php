<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Payment\NL_Checkout;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        if (isset($data['vnp_TransactionStatus']) && $data['vnp_TransactionStatus'] == '00') {
            $payment = PaymentTransaction::where('txnref', $data['vnp_TxnRef'])->first();
            if ($payment) {
                $payment->bank_code = $data['vnp_BankCode'];
                $payment->transaction_no = $data['vnp_TransactionNo'];
                $payment->card_type = $data['vnp_CardType'];
                $payment->status = 'APPROVED';
                $payment->save();
            }
        }


        $payments = PaymentTransaction::whereRaw(1);
        if ($request->service) {
            $payments->where('service',$request->service);
        }
        if ($request->service_code) {
            $payments->where('service_code', 'like', '%' . $request->service_code . '%');
        }
        $payments = $payments->orderByDesc('id')->paginate(30);

        $viewData = [
            'payments' => $payments,
            'query'    => $request->query()
        ];

        return view('payment.index', $viewData);
    }

    public function nganluongList(Request $request)
    {
        return view('payment.create_nganluong', []);
    }

    public function create()
    {
        return view('payment.create');
    }

    public function store(Request $request)
    {
        $service = $request->service;
        switch ($service) {
            case "vnpay":
                $this->createPaymentVnpay($request);
                break;

            case "momo":
                $this->createPaymentMono($request);
                break;
        }
    }

    public function createPaymentMono(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $request->amount;
        $orderId = time() . "";
        $redirectUrl = route('get.payment.index');
        $ipnUrl = route('get.payment.index');
        $extraData = "";


        $requestId = time() . "";
        $requestType = $request->bankCode ?? "captureWallet"; //

        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array (
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'accessKey'   => $accessKey,
            "storeId"     => "MomoTestStore",
            'requestId'   => $requestId,
            'resultCode'  => 0,
            'amount'      => $amount,
            'orderId'     => $orderId,
            'orderInfo'   => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'notifyUrl'   => $redirectUrl,
            'ipnUrl'      => $ipnUrl,
            'lang'        => 'vi',
            'extraData'   => $extraData,
            'requestType' => $requestType,
            'signature'   => $signature
        );

        $this->createPaymentTransaction(array_merge($data, [
            'vnp_TmnCode'   => $partnerCode,
            'vnp_TxnRef'    => $orderId,
            'vnp_OrderInfo' => $orderInfo,
            'vnp_Amount'    => $amount
        ]), $request);

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        header('Location: ' . $jsonResult['payUrl']);
    }

    protected function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array (
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    protected function createPaymentNganLuong(Request $request)
    {
        $flag = true;
        //$ten= $_POST["txt_test"];
        $receiver = config('common.payment.nganluong.receiver');
        //Mã đơn hàng
        $order_code = 'NL_' . time();
        //Khai báo url trả về
        $return_url = "http://123code.abc:8888/payment/";
        // Link nut hủy đơn hàng
        $cancel_url = $_SERVER['HTTP_REFERER'];
        $notify_url = "http://123code.abc:8888/payment/";
        //Giá của cả giỏ hàng
        $txh_name = "Phú phan";
        $txt_email = "codethue94@gmail.com";
        $txt_phone = "0986420994";
        if (strlen($txh_name) > 50 || strlen($txt_email) > 50 || strlen($txt_phone) > 20) {
            $flag = false;
        }
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $txh_name)) {
            $flag = false;
        }
        if ($flag) {
            $price = (int)$request->amount;
            //Thông tin giao dịch
            $transaction_info = "Thong tin giao dich";
            $currency = "vnd";
            $quantity = 1;
            $tax = 0;
            $discount = 0;
            $fee_cal = 0;
            $fee_shipping = 0;
            $order_description = "Thong tin don hang: " . $order_code;
            $buyer_info = $txh_name . "*|*" . $txt_email . "*|*" . $txt_phone;
            $affiliate_code = "";
            //Khai báo đối tượng của lớp NL_Checkout
            $nl = new NL_Checkout();
            $nl->nganluong_url = config('common.payment.nganluong.url');
            $nl->merchant_site_code = config('common.payment.nganluong.merchant_id');
            $nl->secure_pass = config('common.payment.nganluong.merchant_pass');;
            //Tạo link thanh toán đến nganluong.vn
            $url = $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price,
                $currency, $quantity, $tax, $discount, $fee_cal, $fee_shipping, $order_description, $buyer_info,
                $affiliate_code);
            //$url= $nl->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price);


            //echo $url; die;
            if ($order_code != "") {
                //một số tham số lưu ý
                //&cancel_url=http://yourdomain.com --> Link bấm nút hủy giao dịch
                //&option_payment=bank_online --> Mặc định forcus vào phương thức Ngân Hàng
                $url .= '&cancel_url=' . $cancel_url . '&notify_url=' . $notify_url;
                //$url .='&option_payment=bank_online';

                echo '<meta http-equiv="refresh" content="0; url=' . $url . '" >';
                //&lang=en --> Ngôn ngữ hiển thị google translate
            }
        }
    }

    protected function createPaymentVnpay(Request $request)
    {
        $vnp_TmnCode = "N52FKIUG"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "TSIRMJKBXWGVEZWEINMWHTCTDKCAVPYA"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://123code.net/payment";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));


        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        /**
         *
         *
         * @author CTT VNPAY
         */

        $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $request->amount; // Số tiền thanh toán
        $vnp_Locale = $request->language; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = $request->bankCode; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array (
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount * 100,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => $vnp_Locale,
            "vnp_OrderInfo"  => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType"  => "other",
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        $this->createPaymentTransaction($inputData, $request);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }


        header('Location: ' . $vnp_Url);
        die();
    }

    protected function createPaymentTransaction($data, $request)
    {
        PaymentTransaction::create([
            'tmn_code'     => $data['vnp_TmnCode'],
            'txnref'       => $data['vnp_TxnRef'], // max giao dich,
            'note'         => $data['vnp_OrderInfo'],
            'amount'       => $data['vnp_Amount'],
            'status'       => "PENDING",
            'service_code' => $request->service_code ?? 'web',
            'service'      => $request->service,
            'created_at'   => Carbon::now()
        ]);
    }
}
