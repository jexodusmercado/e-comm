<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopViewItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->id,
            'seller_id' => $this->seller_id,
            'product_name' => $this->item_name,
            'description' => $this->description,
            'photo' => $this->photo,
            'price' => $this->price,
            'qty' => $this->qty,
            'created_at' => $this->created_at,
            'company_name' => $this->seller->company_name,
            'rating' => $this->seller->ratings
        ];
    }
}
