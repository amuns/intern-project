<?php

namespace App\Http\Resources;

use App\Models\Api\Category;
use App\Models\Api\HomeSlider;
use App\Models\Api\ProductCategory;
use App\Models\Api\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use function PHPUnit\Framework\isTrue;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'images' => ProductImage::select('image')->where('product_id', $this->id)->get(),
            'price' => $this->price,
            'size' => $this->size,
            'material' => $this->material,
            'warranty' => $this->warranty,
            'color' => $this->color,
            'delivery_description' => $this->delivery_description,
            'categories' => ProductCategory::select('category_id')->where('product_id', $this->id)->get(),
            // 'check' => isTrue(),
            'slider_id'=> HomeSlider::where('product_id', $this->id)->value('id'),
            'slider_image' => HomeSlider::where('product_id', $this->id)->value('image'),
            'slider' => HomeSlider::where('product_id', $this->id)->where('slider', 1)->value('slider'),
            'trending' => HomeSlider::where('product_id', $this->id)->where('trending', 1)->value('trending'),
            'featured' => HomeSlider::where('product_id', $this->id)->where('featured', 1)->value('featured'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
