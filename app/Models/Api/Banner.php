<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends \App\Models\Banner
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}

