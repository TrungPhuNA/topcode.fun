<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Service\ServiceCheckTest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiPaymentController extends Controller
{
    public function add(Request $request)
    {
        try {
            Log::info("----------------- data payment " . json_encode($request->all()));
            $vnp_TmnCode = "7DWKWQQ7"; //Mã định danh merchant kết nối (Terminal Id)
            $vnp_HashSecret = "FVQUCCEAPKPTYUCYJIBRQSAJJJMSFEHS"; //Secret key
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = $request->url_return ?? "http://topcode.fun/payment";
            $startTime = date("YmdHis");
            $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));


            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            if (!$request->service_code || empty($request->service_code)) {
                return response()->json([
                    'link'    => null,
                    'message' => 'Service Code cannot empty!',
                    'status'  => 'fail'
                ]);
            }

            /**
             *
             *
             * @author CTT VNPAY
             */

            $vnp_TxnRef = $request->order_id; //Mã giao dịch thanh toán tham chiếu của merchant
            $vnp_Amount = $request->amount; // Số tiền thanh toán
            $vnp_Locale = $request->language ?? "vn"; //Ngôn ngữ chuyển hướng thanh toán
            $vnp_BankCode = $request->bankCode ?? "VNBANK"; //Mã phương thức thanh toán
//            $vnp_BankCode = $request->bankCode ?? null; //Mã phương thức thanh toán
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
            } else {
                $inputData["vnp_BankCode"] = "VNPAYQR";
            }
            Log::info("---------------- INPUT DATA: " . json_encode($inputData));
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


            return response()->json([
                'link' => $vnp_Url
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'link' => null
            ]);
        }
    }

    protected function createPaymentTransaction($data, $request)
    {
        PaymentTransaction::create([
            'tmn_code'     => $data['vnp_TmnCode'],
            'txnref'       => $data['vnp_TxnRef'], // max giao dich,
            'note'         => $data['vnp_OrderInfo'],
            'amount'       => $data['vnp_Amount'] / 100,
            'status'       => "PENDING",
            'service_code' => $request->service_code,
            'created_at'   => Carbon::now()
        ]);
    }

    public function checkProfile(Request $request)
    {
        $data = $request->all();

        $response = ServiceCheckTest::checkProfile($data);

        return response()->json([
            'data'     => $data,
            'response' => $response
        ]);
    }
}
