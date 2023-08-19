<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => "FAQs",
                'slug' => Str::slug('FAQs', '-'),
            ],
            [
                'title' => "Contact Us",
                'slug' => Str::slug('Contact Us', '-'),

            ],
            [
                'title' => "Shipping",
                'slug' => Str::slug('Shipping', '-'),
            ],
        ];
        Page::insert($pages);
    }

}
