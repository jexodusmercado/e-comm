<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payment;

class PaymentMadeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'product_id'=>'required',
            'user_id'=>'required',
        ]);

        $payment = new Payment;
        $payment->product_id = $request->product_id;
        $payment->user_id    = $request->user_id;
        $payment->save();

        if($payment->save()){
            return response()->json(['status' => 'success'], 200);
        }else{
            return response()->json(['status' => 'failed'], 404);
        }

    }
}
