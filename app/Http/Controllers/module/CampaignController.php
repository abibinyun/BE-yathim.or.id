<?php

namespace App\Http\Controllers\module;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignResource;
use App\Models\Category;

class CampaignController extends Controller
{
	public function indexAllSlug()
    {
        $campaigns = Campaign::select('id', 'slug', 'title')->get();
        return new CampaignResource(true, 'Semua Data Campaign', $campaigns);
    }
	
    public function index(Request $request)
    {
        $query = Campaign::query();
        $categorySlug  = $request->query('category');

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first(); // Cari kategori berdasarkan slug
            if ($category) {
                $query->where('category_id', $category->id); // Filter campaign berdasarkan kategori
            }
        }

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->has('featured')) {
            $query->where('featured', $request->query('featured'));
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('published_at', [$request->query('start_date'), $request->query('end_date')]);
        }

        if ($request->has('keyword')) {
            $keyword = $request->query('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            });
        }

        if ($request->has('sort') && $request->has('order')) {
            $query->orderBy($request->query('sort'), $request->query('order'));
        } else {
            $query->latest();
        }

        $articles = $query->paginate(6);
        return new CampaignResource(true, 'List Data Campaign', $articles);
    }

    public function getByCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $campaigns = Campaign::where('category_id', $category->id)
            ->latest()
            ->paginate(5);

        return new CampaignResource(true, 'List Data Campaign', $campaigns);
    }

    public function show($slug)
    {
        $campaign = Campaign::where('slug', $slug)->first();

        if (!$campaign) {
            return response()->json([
                'success' => false,
                'message' => 'Campaign not found',
            ], 404);
        }

        return new CampaignResource(true, 'Campaign Data', $campaign);
    }
}
