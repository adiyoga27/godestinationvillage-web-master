<?php
namespace App\Http\Controllers\Api\Front;
use App\Blog;
use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\BlogCollection;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\Collections\CommonCollection;
use App\Traits\JsonResponseTrait;

class BlogControllerApi extends Controller
{
    use JsonResponseTrait;

    public function blogs(){
        $data = Blog::where('isPublished','1')->latest('created_date')->paginate(5);
        return $this->responseCollection(new BlogCollection($data));
    }

    public function recentBlogs(){
        $data = Blog::where('isPublished','1')->latest('created_date')->paginate(4);
        return $this->responseCollection(new BlogCollection($data));
    }

    public function detailBlogs($id){
        $data = new BlogResource(Blog::where('id',$id)->first());
        return $this->responseDataMessage($data);
    }

}
