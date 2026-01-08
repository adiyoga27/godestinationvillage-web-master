<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\CommentArticleResource;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\V2\BlogCollection;
use App\Models\Blog;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request) {
        $data = Blog::orderBy('id', 'DESC')->paginate($request->per_page);
        //keyword dari get params
        if(isset($request->keyword)){
            $data = Blog::where('post_title', 'like', '%'.$request->keyword.'%')->orderBy('id', 'DESC')->paginate($request->per_page);
        }
        return new BlogCollection($data);
    }
    public function articlesPopular(Request $request) {
        $data = Blog::orderBy('id', 'DESC')->paginate(5);
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


    public function comment(Request $request, $slugs) {
        $result = PostComment::whereHas('blog', function($q) use($slugs){
             $q->where('slug', $slugs);
        })->where('parent_id', 0)->get();

        return CommentArticleResource::collection($result)->additional([
            'status' => true,
            'message' => 'success'
        ]);
    }
    public function deleteComment(Request $request, $id) {
        $result = PostComment::where('id', $id)->delete();
        return response()->json([
            'status' => true, 
            'message' => "Success Delete Comment"
        ]);
    }

    public function createComment(Request $request, $slugs) {
        $request->validate([
            'comment' => 'required'
        ]);
        try {
           $check = Blog::where('slug', $slugs)->first();
            $result = PostComment::create([
                'post_id' => $check->id,
                'user_id' => Auth::user()->id,
                'parent_id' => 0,
                'comment' => $request->comment
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Success Replies Comment',
                'data' => new CommentArticleResource($result)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => true,
                'message' => 'Failed replies '. $th->getMessage(),
            ], 400);
        }
    }
    public function like(Request $request, $id) {
        $check = PostComment::where('id', $id)->first();
        $likes = json_decode($check->likes);
        if(!$check->likes){
            $likes = [];
        }
        if(!in_array(Auth::user()->id, $likes)){
            $likes = array_merge($likes, [Auth::user()->id]);
            $check->update([
                'likes' => $likes
            ]);
        }
        

        return response()->json([
            'status' => true,
            'message' => "success like"
        ]);
    }
    public function unlike(Request $request, $id) {
        $check = PostComment::where('id', $id)->first();
        $likes = json_decode($check->likes);
        if(!$check->likes){
            $likes = [];
        }
        if(in_array(Auth::user()->id, $likes)){
            $likes = array_diff($likes, [Auth::user()->id]);
            $check->update([
                'likes' => $likes
            ]);
        }
      

        return response()->json([
            'status' => true,
            'message' => "success unlike"
        ]);

        
    }
    public function replies(Request $request, $id) {
        $request->validate([
            'comment' => 'required'
        ]);

        try {
            $check = PostComment::where('id', $id)->first();
            $result = PostComment::create([
                'post_id' => $check->post_id,
                'user_id' => Auth::user()->id,
                'parent_id' => $id,
                'comment' => $request->comment
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Success Replies Comment',
                'data' => new CommentArticleResource($result)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => true,
                'message' => 'Failed replies '. $th->getMessage(),
            ], 400);
        }
    }

    public function likeArticle(Request $request, $slugs) {
        $check = Blog::where('slug', $slugs)->first();
        $likes = $check->liked_by;
       
        if(!in_array(Auth::user()->id, $likes)){
            $likes = array_merge($likes, [Auth::user()->id]);
            $check->update([
                'liked_by' => $likes
            ]);
             return response()->json([
            'status' => true,
            'message' => "success like article"
        ]);
        }else{
            //hapus user id jadinya unlike
            $likes = array_diff($likes, [Auth::user()->id]);
            $check->update([
                'liked_by' => $likes
            ]);
             return response()->json([
            'status' => true,
            'message' => "success unlike article"
        ]);
        }
        

       
    }
}
