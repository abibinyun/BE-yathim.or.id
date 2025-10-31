<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Izinkan semua origin (wildcard)
    'allowed_origins' => ['https://yathim.or.id', 'http://localhost:4321'],

    // Atau bisa pakai pola regex (kalau mau kontrol sebagian domain)
    'allowed_origins_patterns' => [],

    // Izinkan semua metode
    'allowed_methods' => ['GET','POST','PUT','PATCH','DELETE'],

    // Izinkan semua headers
    'allowed_headers' => ['Origin', 'Content-Type', 'Accept', 'Authorization', 'X-Custom-Header'],

    // Kalau mau header tertentu tetap terbuka di response
    'exposed_headers' => [],

    // Cache preflight selama 1 hari
    'max_age' => 86400,

    // Jika pakai session / sanctum, tetap true
    'supports_credentials' => true,
];
