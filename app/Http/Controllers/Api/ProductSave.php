<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

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
                $validateData = $request->validate([
                    'selectedProduct'=>'required',
                    'userId'=>'required',
                    'XXS'=>'required',
                    'XSM'=>'required',
                    'SML'=>'required',
                    'MED'=>'required',
                    'LRG'=>'required',
                    'XLG'=>'required',
                    'XXL'=>'required',
                    'totalQty' => 'required|integer|min:1'
                ]);

		        //image decode and upload to server
		       	$imageFront_data = substr($request->imageFront, strpos($request->imageFront, ',') + 1);
                $imageFront_data = base64_decode($imageFront_data);
				$imageFront_name = date("YmdHis") . "_front" . ".png";

                $imageBack_data = substr($request->imageBack, strpos($request->imageBack, ',') + 1);
                $imageBack_data = base64_decode($imageBack_data);
				$imageBack_name = date("YmdHis") . "_back" . ".png";

				Storage::disk('uploads')->put($imageFront_name, $imageFront_data);
                Storage::disk('uploads')->put($imageBack_name, $imageBack_data);

                //getting value from page
                $selectedProduct = $request->selectedProduct;
                $userId = $request->userId;
                $XXS = $request->XXS;
                $XSM = $request->XSM;
                $SML = $request->SML;
                $MED = $request->MED;
                $LRG = $request->LRG;
                $XLG = $request->XLG;
                $XXL = $request->XXL;
                $totalQty = $request->totalQty;


				//insert details into database
				$product = new Product;
			    $product->imageFront = $imageFront_name;
                $product->imageBack = $imageBack_name;
                $product->selectedProduct = $selectedProduct;
                $product->user_id = $userId;
                $product->XXS = $XXS;
                $product->XSM = $XSM;
                $product->SML = $SML;
                $product->MED = $MED;
                $product->LRG = $LRG;
                $product->XLG = $XLG;
                $product->XXL = $XXL;
                $product->totalQty = $totalQty;
                $product->save();

			    if($product->save()){
			    	return response()->json([], 200);
			    }else{
			    	return response()->json([], 404);
			    }
		    } else {
                return response()->json([], 404);
            }


    }
}
