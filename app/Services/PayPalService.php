<?php
/**
 * Created By PhpStorm
 * User: trungphuna
 * Date: 1/25/24
 * Time: 12:20 AM
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    public static function processCreateLink(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent"              => "CAPTURE",
                "application_context" => [
                    "return_url" => $request->url_success,
                    "cancel_url" => $request->url_cancel,
                ],
                "purchase_units"      => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value"         => $request->amount
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return [
                            'link' => $links['href']
                        ];
                    }
                }
                return [
                    'link' => $request->url_error
                ];
            } else {
                return [
                    'link' => $request->url_error
                ];
            }
        } catch (\Exception $exception) {
            Log::error("==============PayPalService@processCreateLink  " . json_encode($exception->getMessage()));
        }

        return [
            'link' => null
        ];
    }
}