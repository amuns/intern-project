<?php

namespace App\Models\Api;

class ShippingCharge extends \App\Models\ShippingCharge
{
    public function getRouteKeyName(){
        return 'id';
    }
}
