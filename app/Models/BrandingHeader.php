<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandingHeader extends Model
{
    use HasFactory;
    
    protected $fillable = ['logo', 'company_name'];
}
