<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\SliderResource;
use App\Models\Slider;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Homestay;
use App\Models\Package;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function sliders() {
        $data = Slider::all();
        return SliderResource::collection($data)->additional([
            'status' => true,
            'message' => 'Success'
        ]);
    }
    public function embedComment(Request $request, $slug){
        $blog = Blog::where('slug', $slug)->first();

        return view('customer/comment', compact('blog'));
    }

    public function search(Request $request, $keyword) {
        $result = [];
        $events = Event::select('id', 'name', 'slug','default_img')->where('name', 'like','%'.$keyword.'%')->limit(5)->get();
        foreach ($events as $e) {
            $result[] = array(
                'id' => $e->id,
                'type' =>'event',
                'name' =>$e->name,
                'slug' =>$e->slug,
                'thumbnail' => url('storage/events')."/".$e->default_img
            );
        }
        $homestay = Homestay::select('id', 'name', 'slug','default_img')->where('name', 'like','%'.$keyword.'%')->limit(5)->get();
        foreach ($homestay as $h) {
            $result[] = array(
                'id' => $h->id,
                'type' =>'homestay',
                'name' =>$h->name,
                'slug' =>$h->slug,
                'thumbnail' => url('storage/homestay')."/".$h->default_img

            );
        }
        $tours = Package::select('id', 'name', 'slug','default_img')->where('name', 'like','%'.$keyword.'%')->limit(5)->get();
        foreach ($tours as $t) {
            $result[] = array(
                'id' => $t->id,
                'type' =>'tour',
                'name' =>$t->name,
                'slug' =>$t->slug,
                'thumbnail' => url('storage/packages')."/".$t->default_img

            );
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $result
        ]);
    }
    
}
