<?php

namespace App\Http\Controllers\module;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageBannerResource;
use App\Models\PageBanner;
use Illuminate\Http\Request;

class PageBannerController extends Controller
{
    public function index()
    {
        $page_banner = PageBanner::latest()->paginate(5);

        return new PageBannerResource(true, 'List Data page banner', $page_banner);
    }
}
