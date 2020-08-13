<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inquiry;

class InquiryStoreController extends Controller
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $inquire = new Inquiry;
        $inquire->first_name = $request->first_name;
        $inquire->last_name  = $request->last_name;
        $inquire->email      = $request->email;
        $inquire->subject    = $request->subject;
        $inquire->message    = $request->message;

        if($inquire->save()){
			return response()->json(['status' => 'success'], 200);
        }else{
			return response()->json(['status' => 'failed'], 402);
        }
    }
}
