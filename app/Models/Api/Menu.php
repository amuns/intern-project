<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends \App\Models\Menu
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
