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
        if (preg_match('/^data:image\/(\w+);base64,/', $request->imageFront) && preg_match('/^data:image\/(\w+);base64,/', $request->imageBack))
		    {
		        	//image decode and upload to server
		       	    $imageFront_data = substr($request->imageFront, strpos($request->imageFront, ',') + 1);
                    $imageFront_data = base64_decode($imageFront_data);
				    $imageFront_name = date("YmdHis") . "_front" . ".png";

                    $imageBack_data = substr($request->imageBack, strpos($request->imageBack, ',') + 1);
                    $imageBack_data = base64_decode($imageBack_data);
				    $imageBack_name = date("YmdHis") . "_back" . ".png";

				    Storage::disk('uploads')->put($imageFront_name, $imageFront_data);
				    Storage::disk('uploads')->put($imageBack_name, $imageBack_data);

				    //insert details into database
				    $product = new Product;
			        $product->imageFront = $imageFront_name;
                    $product->imageBack = $imageBack_name;

			        if($product->save()){
			        	return response()->json(['status' => 'success'], 200);
			    	}else{
			    		return response()->json(['status' => 'Failed'], 404);
			    	}
		    } else {
                return response()->json(['status' => ''], 400);
            }


    }
}
