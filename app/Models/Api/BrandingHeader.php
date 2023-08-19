<?php

namespace App\Models\Api;


class BrandingHeader extends \App\Models\BrandingHeader
{
    public function getRouteKeyName()
    {
        return 'id';
    }
}
