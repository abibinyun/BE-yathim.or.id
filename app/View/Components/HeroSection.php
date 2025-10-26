<?php

namespace App\View\Components;

use Closure;
use App\Models\PageBanner;
use App\Models\SiteSetting;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class HeroSection extends Component
{
    public $title;
    public $subtitle;
    public $banners = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $setting = SiteSetting::first();

        // Mengambil data default
        $this->title = $setting->site_name; // Atau pengaturan lain yang sesuai
        $this->subtitle = $setting->site_description; // Atau pengaturan lain yang sesuai

        // Mendapatkan URL halaman saat ini
        $currentPage = request()->route()->getName(); // Mengambil nama route saat ini

        // Mengambil banner spesifik untuk halaman
        $this->banners = PageBanner::where('page_identifier', $currentPage)->pluck('banner_image')->toArray();

        // Jika tidak ada banner spesifik, gunakan gambar default
        if (empty($this->banners)) {
            $this->banners = [$setting->default_hero_image];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.hero-section');
    }
}
