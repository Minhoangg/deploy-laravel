<?php

namespace App\Http\Controllers\client\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Client\order\StoreOrderRequest;
use App\Models\Product;
use App\Models\OrderModel;
use App\Models\StatusOrder;
use PayOS\PayOS;


class PaymentController extends Controller
{
    public function createPaymentHandle(Request $request)
    {

        $order = OrderModel::find($request->input('order_id'));

        $data = [
            "orderCode" => intval(substr(strval(microtime(true) * 10000), -6)),
            "amount" => $order->total,
            "description" => "Thanh toán đơn hàng",
            "returnUrl" => "https://ftech.minhhoang04.id.vn",
            "cancelUrl" => "https://minhhoang04.id.vn"
        ];

        $PAYOS_CLIENT_ID = env('PAYOS_CLIENT_ID');
        $PAYOS_API_KEY = env('PAYOS_API_KEY');
        $PAYOS_CHECKSUM_KEY = env('PAYOS_CHECKSUM_KEY');

        $payOS = new PayOS($PAYOS_CLIENT_ID, $PAYOS_API_KEY, $PAYOS_CHECKSUM_KEY);
        try {
            $response = $payOS->createPaymentLink($data);
            return response()->json(['checkoutUrl' => $response]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    

}
