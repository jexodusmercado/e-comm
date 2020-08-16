<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rating;
use App\User;

class RatingStoreController extends Controller
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
            'buyer_id'=>'required',
            'seller_id'=>'required',
            'rating'=>'required',
        ]);


        $rate = new Rating;

        $result  = Rating::where('product_id', $request->product_id)->where('buyer_id', $request->buyer_id)->get();
        if(count($result) > 0){
            return response()->json([], 422);
        }else{
        $rate->product_id   = $request->product_id;
        $rate->buyer_id     = $request->buyer_id;
        $rate->seller_id    = $request->seller_id;
        $rate->rating       = $request->rating;
        $rate->comment      = $request->comment;

        if($rate->save()){
            $totalStars = Rating::where('seller_id', $request->seller_id)->avg('rating');
            $user = User::findOrFail($request->seller_id);
            $user->ratings = round($totalStars);
            $user->save();

            return response()->json([]);
        }else{
            return response()->json([], 404);
        }
        }
    }
}
