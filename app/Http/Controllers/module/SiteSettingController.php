<?php

namespace App\Http\Controllers\module;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiteSettingResource;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function index()
    {
        $site_setting = SiteSetting::latest()->paginate(5);

        return new SiteSettingResource(true, 'List Data Site Setting', $site_setting);
    }
}
