<?php

namespace App\Http\Resources;

use App\Models\Api\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSliderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'product_id'=>$this->product_id,
            'slider' => $this->slider,
            'trending' => $this->trending,
            'featured' => $this->featured,
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
