<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use App\Order;
use App\Order_detail;

class ShopOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $item = Shop::findOrFail($request->shop_id);

        $item->qty = $item->qty - 1;
        $item->save();


    }
}
