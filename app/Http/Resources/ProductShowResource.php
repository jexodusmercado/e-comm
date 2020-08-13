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
        if(count($this->deliverable) == 0){
            $deliverables = null;
            $status = null;
        }else{
            $deliverables = $this->deliverable;
            $status = $this->deliverable.status;
        }

        return [
            'product_id'  => $this->id,
            'user_id'     => $this->user_id,
            'category'    => $this->selectedProduct,
            'front'       => $this->imageFront,
            'back'        => $this->imageBack,
            'XXS'         => $this->XXS,
            'XSM'         => $this->XSM,
            'SML'         => $this->SML,
            'MED'         => $this->MED,
            'LRG'         => $this->LRG,
            'XLG'         => $this->XLG,
            'XXL'         => $this->XXL,
            'total'       => $this->totalQty,
            'email'       => $email,
            'moblie'      => $mobile,
            'address1'    => $address1,
            'address2'    => $address2,
            'barangay'    => $barangay,
            'city'        => $city,
            'province'    => $province,
            'deliverable' => $deliverables,
            'status'      => $status
        ];
    }
}
