<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Deliverable;
use App\Http\Resources\DeliverableIndexResource;


class DeliverableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return DeliverableIndexResource::collection(

               Deliverable::where('buyer_id',$id)
                          ->whereHas('product', function ($query){
                              return $query->where('deleted_at', null);
                          })
                          ->orderBy('created_at', 'asc')
                          ->paginate(8)

        );
    }

    public function sellerIndex($id)
    {
        return DeliverableIndexResource::collection(

               Deliverable::where('seller_id',$id)
                          ->whereHas('product', function ($query){
                              return $query->where('deleted_at', null);
                          })
                          ->orderBy('created_at', 'asc')
                          ->paginate(8)

        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Deliverable::where('product_id', $id)
                          ->with('seller')
                          ->with('buyer')
                          ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $status  = $request->status;
        $deliver = Deliverable::findOrFail($request->id)
                                ->update(['status' => $request->status]);


        if($deliver){
            return response()->json([]);
        }else{
            return response()->json([], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
