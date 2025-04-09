<?php

namespace App\Http\Controllers;

use App\Models\DatVe;
use Carbon\Carbon;
use Date;
use GuzzleHttp\Client;
use Http;
use Illuminate\Http\Request;
use Log;

class MoMoPaymentController extends Controller
{
    protected $accessKey = 'F8BBA842ECF85';
    protected $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
    public function createPayment(Request $request)
    {
        $orderInfo = 'pay with MoMo';
        $partnerCode = 'MOMO';
        $redirectUrl = 'https://datvexemphim-psi.vercel.app/';
        $ipnUrl = 'https://be-da-web-nam4.onrender.com/api/callback';
        $requestType = "payWithMethod";
        $amount = $request->amount;
        $orderId = $request->orderId;
        $requestId = $orderId;
        $extraData = '';
        $orderGroupId = '';
        $autoCapture = true;
        $lang = 'vi';
        $rawSignature = "accessKey=" . $this->accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac('sha256', $rawSignature, $this->secretKey);
        $requestBody = [
            'partnerCode' => $partnerCode,
            'partnerName' => 'Test',
            'storeId' => 'MomoTestStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => $lang,
            'requestType' => $requestType,
            'autoCapture' => $autoCapture,
            'extraData' => $extraData,
            'orderGroupId' => $orderGroupId,
            'signature' => $signature
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://test-payment.momo.vn/v2/gateway/api/create', $requestBody);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Không thể tạo yêu cầu thanh toán'], 500);
    }


    public function callback(Request $request)
    {
        if ($request->resultCode == '0') {
            $orderId = $request->orderId;

            $datve = DatVe::where('ma_ve', $orderId)->first();
            if ($datve) {
                $datve->trang_thai = 'Đã thanh toán';
                $datve->save();
            }

            return response()->json(['status' => 'success', 'message' => 'Payment processed successfully']);
        }

        return response()->json(['status' => 'fail'], 400);
    }


    public function ipn(Request $request)
    {
        $orderId = $request->input('orderId');
        $requestId = $orderId;

        if (empty($orderId)) {
            return response()->json([
                'error' => 'Missing orderId'
            ], 400);
        }

        $rawSignature = "accessKey={$this->accessKey}" . "&orderId={$orderId}" . "&partnerCode=MOMO" .
            "&requestId={$requestId}";
        $signature = hash_hmac('sha256', $rawSignature, $this->secretKey);

        $requestBody = [
            'partnerCode' => 'MOMO',
            'requestId' => $orderId,
            'orderId' => $orderId,
            'signature' => $signature,
            'lang' => 'vi'
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://test-payment.momo.vn/v2/gateway/api/query', $requestBody);


        if ($response->successful()) {
            $data = $response->json();
            if ($data['resultCode'] == '0') {

                $datve = DatVe::where('ma_ve', $orderId)->first();
                if ($datve) {
                    $datve->trang_thai = 'Đã thanh toán';
                    $datve->save();
                }
                return response()->json(['status' => 'success', 'message' => 'Payment processed successfully']);
            } else {

                return response()->json(['status' => 'fail', 'message' => 'Payment failed'], 400);
            }
        }

        return response()->json(['error' => 'Unable to check transaction status'], 500);
    }
}
