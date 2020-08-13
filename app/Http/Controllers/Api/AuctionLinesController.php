<?php

namespace App\Http\Controllers\Api;

use App\Auction_line;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuctionLinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Auction_line  $auction_line
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Auction_line::where('product_id', $id)
                            ->with('user')
                            ->orderBy('offer_amount', 'asc')
                            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Auction_line  $auction_line
     * @return \Illuminate\Http\Response
     */
    public function edit(Auction_line $auction_line)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Auction_line  $auction_line
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction_line $auction_line)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Auction_line  $auction_line
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction_line $auction_line)
    {
        //
    }
}
