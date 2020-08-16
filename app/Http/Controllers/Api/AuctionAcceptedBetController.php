<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auction;
use App\Deliverable;
use App\Payment;
use App\Market;
use App\Auction_line;

class AuctionAcceptedBetController extends Controller
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
            'product_id'        =>'required',
            'buyer_id'          =>'required',
            'seller_id'         =>'required',
            'offer_amount'      =>'required',
            'shipping_amount'   =>'required',
        ]);

        $auction = new Auction;
        $auction->product_id      = $request->product_id;
        $auction->user_id         = $request->buyer_id;
        $auction->offer_amount    = $request->offer_amount;
        $auction->shipping_amount = $request->shipping_amount;
        $auction->save();


        $deliverable = new Deliverable;
        $deliverable->product_id = $request->product_id;
        $deliverable->buyer_id   = $request->buyer_id;
        $deliverable->seller_id  = $request->seller_id;
        $deliverable->save();

        $payment = new Payment;
        $payment->product_id = $request->product_id;
        $payment->user_id    = $request->buyer_id;
        $payment->save();

        $market = Market::where('product_id', $request->product_id)->update(['active'=> 0]);
        $auction = Auction_line::where('id', $request->auctionLineId)->update(['accepted' => 1]);
        // $market->where('product_id', $request->product_id);
        // $market->update(['active'=> 0]);

        if($auction && $deliverable && $payment){
            return response()->json([], 200);
        }else{
            return response()->json(['status' => 'failed'], 404);
        }
    }
}
