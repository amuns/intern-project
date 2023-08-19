<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends \App\Models\Testimonial
{
    public function getRouteKeyName(){
        return 'id';
    }
}
