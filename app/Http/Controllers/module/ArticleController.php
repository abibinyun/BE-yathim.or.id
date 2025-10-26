<?php

namespace App\Http\Controllers\module;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
	
	public function indexAllSlug()
    {
        $articles = Article::select('id', 'slug', 'title')->get();
        return new ArticleResource(true, 'Semua Data Artikel', $articles);
    }


    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('category')) {
            $query->where('category', $request->query('category'));
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

        $articles = $query->paginate(10);
        return new ArticleResource(true, 'List Data Campaign', $articles);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found',
            ], 404);
        }

        return new ArticleResource(true, 'Article Data', $article);
    }
}
