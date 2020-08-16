<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Market;

class MarketStoreProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validateData = $request->validate([
            'product_id'=>'required',
        ]);

        $product_id = $request->product_id;

        $market = new Market;

        $market->product_id = $product_id;
        $market->active = 1;
        $market->save();

        if($product-save()){
            return response()->json(['status' => 'success'], 200);
        }else{
            return response()->json(['status' => 'failed'], 404);
        }

    }
}
