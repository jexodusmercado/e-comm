<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use App\Http\Resources\ShopViewItemResource;
use App\Http\Resources\ShopIndexItemResource;

class ShopController extends Controller
{

    public function index()
    {
        return ShopIndexItemResource::collection(
            Shop::where('active', 1)->paginate(8)
        );
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'seller_id'=>'required',
            'product_name'=>'required',
            'product_description'=>'required',
            'product_price'=>'required',
            'product_quantity'=>'required',
            'product_photo'=>'required',
        ]);


        $file = $data['product_photo'];
        $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
        $path = public_path() . '/shops';
        $res = $file->move($path, $name);

        $shop = new Shop;

        $shop->seller_id    = $data['seller_id'];
        $shop->item_name    = $data['product_name'];
        $shop->description  = $data['product_description'];
        $shop->price        = $data['product_price'];
        $shop->qty          = $data['product_quantity'];
        $shop->photo        = $name;

        if($shop->save()){
            return response()->json([], 200);
        }else{
            return response()->json([], 404);
        }

    }

    public function show($id)
    {
        return Shop::where('seller_id', $id)
                    ->latest()
                    ->get();
    }

    public function showPerItem($id){
        return ShopViewItemResource::collection(
            Shop::where('id', $id)
            ->with('seller')
            ->get()
        );
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        // dd($request->product_photo);
        $shop = Shop::findOrFail($id);
        $name = "";
        if($request->product_photo){
            $file = $request->product_photo;
            $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/shops';
            $res = $file->move($path, $name);
        }

        $item_name      = $request->product_name ? $request->product_name : $shop->item_name;
        $description    = $request->product_description ? $request->product_description : $shop->description;
        $price          = $request->product_price ? $request->product_price : $shop->price;
        $qty            = $request->product_qty ? $request->product_qty : $shop->qty;
        $photo          = $name ? $name : $shop->photo;


        $shop->item_name        = $item_name;
        $shop->description      = $description;
        $shop->price            = $price;
        $shop->qty              = $qty;
        $shop->photo            = $photo;

        if($shop->save()){
            return response()->json([]);
        }else{
            return response()->json([], 422);
        }
    }


    public function toggleActivation($id, $status){
        $shop = Shop::findOrFail($id);

        $shop->active = $status;

        if($shop->save()){
            return response()->json([], 200);
        }else{
            return response()->json([], 404);

        }

    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);

        if($shop->delete()){
            return response()->json([], 200);
        }else{
            return response()->json([], 404);
        }


    }
}
