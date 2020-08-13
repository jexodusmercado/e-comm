<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auction_line;

class AuctionStoreBetController extends Controller
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
            'seller_id'=>'required',
            'offer_amount'=>'required',
            'shipping_amount'=>'required',
        ]);

        $auction = new Auction_line;

        $result  = Auction_line::where('product_id', $request->product_id)->where('seller_id', $request->seller_id)->get();
        if(count($result) > 0){
            return response()->json([], 422);
        }else{
        $auction->product_id = $request->product_id;
        $auction->seller_id    = $request->seller_id;
        $auction->offer_amount = $request->offer_amount;
        $auction->shipping_amount = $request->shipping_amount;

        if($auction->save()){
            return response()->json([]);
        }else{
            return response()->json([], 404);
        }
        }


    }
}
