<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $table = 'products';

    protected $fillable = [
        'title', 'description', 'price', 'published', 'created_by', 'updated_by', 
        'size', 'color', 'material', 'warranty', 'delivery_description'
    ];

    public function images(): HasOne{
        return $this->hasOne(ProductImage::class);
    }

    public function featured(): HasOne {
        return $this->hasOne(HomeSlider::class)->where('featured', 1);
    }

    public function trending(): HasOne {
        return $this->hasOne(HomeSlider::class)->where('trending', 1);
    }

    public function slider(): HasOne {
        return $this->hasOne(HomeSlider::class)->where('slider', 1);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
