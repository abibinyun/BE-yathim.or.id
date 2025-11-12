<?php

use App\Http\Controllers\module\HomeController;
use App\Http\Controllers\module\CampaignController;
use App\Http\Controllers\module\DonationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');

