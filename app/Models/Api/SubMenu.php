<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends \App\Models\SubMenu
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
