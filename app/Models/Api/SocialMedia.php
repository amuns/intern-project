<?php

namespace App\Models\Api;

class SocialMedia extends \App\Models\SocialMedia
{
    public function getRouteKeyName(){
        return 'id';
    }
}
