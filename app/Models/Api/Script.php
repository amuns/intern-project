<?php

namespace App\Models\Api;


class Script extends \App\Models\Script
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
