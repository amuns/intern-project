<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends \App\Models\Page
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
