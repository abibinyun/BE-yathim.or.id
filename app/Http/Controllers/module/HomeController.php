<?php

namespace App\Http\Controllers\module;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return redirect(config('app.url') . '/admin');
    }
}
