<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'site_name' => 'My Website',
            'site_description' => 'Welcome to My Website',
            'site_logo' => 'logo.png',
            'favicon' => 'favicon.ico',
            'contact_email' => 'contact@example.com',
            'phone_number' => '123-456-7890',
            'address' => '123 Street Name, City, Country',
            'default_hero_image' => 'default-hero.jpg'
        ]);
    }
}
