<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socialMedias = [
            [
                'title' => 'facebook',
                'link' => 'https://www.facebook.com/',
            ],
            [
                'title' => 'instagram',
                'link' => 'https://www.instagram.com/',
            ],
            [
                'title' => 'twitter',
                'link' => 'https://www.twitter.com/',
            ],
            [
                'title' => 'linkedIn',
                'link' => 'https://www.linkedin.com/',
            ],
        ];

        SocialMedia::insert($socialMedias);
    }
}
