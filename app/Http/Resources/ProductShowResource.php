<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResource extends JsonResource
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
            'user_id' => $this->user_id,
            'category' => $this->selectedProduct,
            'images' => [
                'front' => $this->image_front,
                'back' => $this->image_back
            ],
            'sizes' => [
                'XXS' => $this->XXS,
                'XSM' => $this->XSM,
                'SML' => $this->SML,
                'MED' => $this->MED,
                'LRG' => $this->LRG,
                'XLG' => $this->XLG,
                'LRG' => $this->LRG
            ],
            'total' => $this->totalQty,
            'created' => $this->created_at

        ];
    }
}
