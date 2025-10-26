<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    use HasFactory;

    protected $fillable = ['page_identifier', 'banner_image', 'title', 'subtitle', 'isVideo', 'video', 'isButton', 'button_text', 'button_link', 'video_slides'];

    // Pastikan untuk casting kolom JSON
    protected $casts = [
        'video_slides' => 'array',  // Mengonversi kolom video_slides menjadi array
    ];
}
