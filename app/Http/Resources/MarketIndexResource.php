<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarketIndexResource extends JsonResource
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
            'market_id' => $this->id,
            'active' => $this->active,
            'created' => $this->created_at,
            'expired_at' => $this->expired_at,
            'product_id' => $this->product_id,
            'front' => $this->product->imageFront,
            'back' => $this->product->imageBack,
            'category' => $this->product->selectedProduct,
            'deleted_at' => $this->product->deleted_at,

        ];
    }
}
