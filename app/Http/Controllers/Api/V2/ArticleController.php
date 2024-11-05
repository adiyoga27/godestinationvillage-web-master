<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\V2\BlogCollection;
use App\Models\Blog;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request) {
        $data = Blog::orderBy('id', 'DESC')->paginate($request->per_page);
        return new BlogCollection($data);
    }
    
    public function show(Request $request, $slugs) {
        $blog = Blog::where('slug', $slugs)->first();
        return response()->json([
            'status' => true,
            'message' => "Success",
            'data' => new BlogResource($blog)
        ]);
    }
}
