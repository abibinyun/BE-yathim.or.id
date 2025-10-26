<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',         // Judul artikel
        'slug',          // Slug artikel (unik)
        'content',       // Konten artikel
        'excerpt',       // Ringkasan artikel
        'published_at',  // Tanggal publikasi
        'category',      // Kategori artikel (news, stories, dll)
        'status',        // Status artikel (draft, published, dll)
        'featured',      // Featured artikel (primary, hot, none)
        'image',         // Path gambar artikel
    ];
}
