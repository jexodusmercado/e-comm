<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $deliverable    = !$this->deliverable ? '' : $this->deliverable;
        $market         = !$this->market ? '' : $this->market;

        return [
            'product_id'    => $this->id,
            'user_id'       => $this->user_id,
            'category'      => $this->selectedProduct,
            'front'         => $this->imageFront,
            'back'          => $this->imageBack,
            'XXS'           => $this->XXS,
            'XSM'           => $this->XSM,
            'SML'           => $this->SML,
            'MED'           => $this->MED,
            'LRG'           => $this->LRG,
            'XLG'           => $this->XLG,
            'LRG'           => $this->LRG,
            'total'         => $this->totalQty,
            'created'       => $this->created_at,
            'market'        => $market,
            'deliverable'   => $deliverable,

        ];
    }
}
