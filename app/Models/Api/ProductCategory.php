<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends \App\Models\ProductCategory
{
    public function getRouteKeyName(){
        return 'id';
    }
}
