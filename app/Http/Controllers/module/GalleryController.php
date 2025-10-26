<?php

namespace App\Http\Controllers\module;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery; // Pastikan Gallery memang relevan untuk Moments
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // Jika parameter `sidebar` diberikan, hanya tampilkan nama moment
        if ($request->has('sidebar')) {
            $moments = Gallery::select('id', 'name')->get();

            return response()->json([
                'success' => true,
                'message' => 'List of moment names for sidebar',
                'data' => $moments,
            ]);
        }

        if ($request->has('name') || $request->has('moment')) {
            $momentName = $request->query('name') ?? $request->query('moment');

            // Cari moment berdasarkan name
            $moment = Gallery::where('name', $momentName)->first();

            if (!$moment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Moment not found',
                ], 404);
            }

            // Ambil parameter halaman dan batas data per halaman
            $perPage = 6; // Batas jumlah data per halaman
            $currentPage = $request->query('page', 1); // Halaman saat ini, default ke 1
            $images = $moment->images; // Semua gambar dari kolom images

            // Hitung offset dan slice array
            $offset = ($currentPage - 1) * $perPage;
            $paginatedImages = array_slice($images, $offset, $perPage);

            // Buat data pagination secara manual
            $paginationData = [
                'current_page' => $currentPage,
                'data' => $paginatedImages,
                'per_page' => $perPage,
                'total' => count($images),
                'last_page' => ceil(count($images) / $perPage),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Images for the selected moment',
                'data' => $paginationData,
            ]);
        }

        // Jika tidak ada parameter, tampilkan semua moment beserta gambar
        $moments = Gallery::paginate(10);

        return new GalleryResource(true, 'List of all moments and images', $moments);
    }
}
