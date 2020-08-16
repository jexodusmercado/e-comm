<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliverableIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $fullName = $this->buyer['last_name'].', '.$this->buyer['first_name'];

        return [
            'delivery_id'       => $this->id,
            'product_id'        => $this->product_id,
            'delivery_status'   => $this->status,
            'accepted'          => $this->created_at,
            'image'             => $this->product['imageFront'],
            'full_name'         => $fullName,
            'total_amount'      => $this->auction['offer_amount']+$this->auction['shipping_amount'],
        ];
    }
}
