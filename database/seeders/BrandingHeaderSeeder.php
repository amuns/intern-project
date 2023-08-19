<?php

namespace Database\Seeders;

use App\Models\BrandingHeader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandingHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BrandingHeader::create(['company_name' => 'CompanyName']);
    }
}
