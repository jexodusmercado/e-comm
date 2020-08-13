<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductAsset extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // $validateData = $request->validate([
        //     'asset_image'=>'required|mimes:jpeg,jpg,png|max:99999999'
        // ]);
        // $file = $request->file('asset_image');
        // $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
        // $path = public_path() . '/design_assets';
        // $res = $file->move($path, $name);

        // if($res){
        //     return response()->json(['status' => 'success','file_name' => $name], 200);

        // }else{
        //     return response()->json(['status' => 'fail'], 422);
        // }


    }
}
