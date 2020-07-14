<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Auction;

class ProductSave extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $request->imageData))
		        {

		        	//image decode and upload to server
		       	    $data = substr($request->imageData, strpos($request->imageData, ',') + 1);
				    $data = base64_decode($data);
				    $imageName = date("YmdHis") . "_" . $request->userID . ".png";

				    Storage::disk('uploads')->put($imageName, $data);

				    //insert details into database
				    $product = new Product;
			        $product->user_id = $request->userID;
			        $product->product_name = $request->productName;
			        $product->image_name = $imageName;

			        if($product->save()){
			        	$auction = new Auction;
			        	$auction->product_id = $product->id;
			        	$auction->auction_status = 0;
			        	$auction->quantity = 0;
			        	$auction->save();
			        	return response()->json(['status' => 'success'], 200);
			    	}else{
			    		return response()->json(['status' => 'Failed'], 404);
			    	}
				}
    }
}
