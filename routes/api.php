<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\module\CampaignController;
use App\Http\Controllers\module\ArticleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/bank-account', App\Http\Controllers\module\BankAccountController::class);
Route::apiResource('/campaign', App\Http\Controllers\module\CampaignController::class);
Route::apiResource('/donation', App\Http\Controllers\module\DonationController::class);
Route::apiResource('/page-banner', App\Http\Controllers\module\PageBannerController::class);
Route::apiResource('/site-setting', App\Http\Controllers\module\SiteSettingController::class);
Route::apiResource('/category', App\Http\Controllers\module\CategoryController::class);
Route::apiResource('/article', App\Http\Controllers\module\ArticleController::class);
Route::apiResource('/gallery', App\Http\Controllers\module\GalleryController::class);

Route::get('/campaign/category/{categoryId}', [CampaignController::class, 'getByCategory']);
Route::get('/campaigns/all/slug', [CampaignController::class, 'indexAllSlug']);
Route::get('/articles/all/slug', [ArticleController::class, 'indexAllSlug']);
