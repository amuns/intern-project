<?php

namespace App\Http\Resources;

use App\Models\Api\Category;
use App\Models\Api\ProductCategory;
use App\Models\Api\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductResource extends JsonResource
{
    public static $wrap = false;

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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'images' => ProductImage::select('image')->where('product_id', $this->id)->get(),
            'price' => $this->price,
            'size' => $this->size,
            'material' => $this->material,
            'warranty' => $this->warranty,
            'color' => $this->color,
            'delivery_description' => $this->delivery_description,
            // 'category' => Category::where('id', $this->category_id)->get(),
            'categories' => ProductCategory::select('category_id')->where('product_id', $this->id)->get(),
            'published' => (bool)$this->published,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
