<?php

namespace App\Models\Api;


class HomeSlider extends \App\Models\HomeSlider
{
    public function getRouteKeyName(){
        return 'id';
    }
}
