<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\BlogCollection;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\Events\EventCollection;
use App\Http\Resources\Events\EventResource;
use App\Http\Resources\Homestay\HomestayCollection;
use App\Http\Resources\Homestay\HomestayResource;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Homestay;
use Illuminate\Http\Request;

class PageControllerApi extends Controller
{

    public function __construct(
        public Blog $blog,
        public Homestay $homestay,
        public Event $event
    ) {
    }
    public function blog(Request $request)
    {
        $blogs = $this->blog->orderBy('id', 'DESC')->paginate($request->per_page);

        if(!empty($request->keyword)){
            $blogs = $this->blog->orderBy('id', 'DESC')->where('post_title', 'like', '%'.$request->keyword.'%')->paginate($request->per_page);
        }
        return response()->json(new BlogCollection($blogs));
    }


    public function detailBlog(Request $request, $id)
    {
        $blog = $this->blog->where('id', $id)->first();
        if(!$blog){
            return response()->json([
                'data' => [],
                'status' => FALSE,
                'messages' => 'Your data not found'
            ]);
        }
        return response()->json([
            'data' => new BlogResource($blog),
            'status' => TRUE,
            'messages' => 'Success'
        ]);
    }

    public function homestay(Request $request)
    {
        $homestays = $this->homestay->orderBy('id', 'DESC')->paginate($request->per_page);
        if(!empty($request->keyword)){
            $homestays = $this->homestay->orderBy('id', 'DESC')->where('name', 'like', '%'.$request->keyword.'%')->paginate($request->per_page);
        }
        return response()->json(new HomestayCollection($homestays));

    }

    public function detailHomestay(Request $request, $id)
    {
        $homestay = $this->homestay->where('id', $id)->first();
        if(!$homestay){
            return response()->json([
                'data' => [],
                'status' => FALSE,
                'messages' => 'Your data not found'
            ]);
        }
        return response()->json([
            'data' => new HomestayResource($homestay),
            'status' => TRUE,
            'messages' => 'Success'
        ]);
    }


    public function events(Request $request)
    {
        $events = $this->event->orderBy('id', 'DESC')->paginate($request->per_page);
        if(!empty($request->keyword)){
            $events = $this->event->orderBy('id', 'DESC')->where('name', 'like', '%'.$request->keyword.'%')->paginate($request->per_page);
        }
        return response()->json(new EventCollection($events));
    }

    public function detailEvent(Request $request, $id)
    {
        $event = $this->event->where('id', $id)->first();
        if(!$event){
            return response()->json([
                'data' => [],
                'status' => FALSE,
                'messages' => 'Your data not found'
            ]);
        }
        return response()->json([
            'data' => new EventResource($event),
            'status' => TRUE,
            'messages' => 'Success']);
    }
}
