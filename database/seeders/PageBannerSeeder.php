<?php

namespace Database\Seeders;

use App\Models\PageBanner;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PageBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageBanner::create(['page_identifier' => 'home', 'banner_image' => '/banner_image/home-banner1.png']);
        PageBanner::create(['page_identifier' => 'campaign', 'banner_image' => '/banner_image/campaign-banner2.jpg']);
        PageBanner::create(['page_identifier' => 'about', 'banner_image' => '/banner_image/about-banner.jpg']);
    }
}
