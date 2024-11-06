<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\SliderResource;
use App\Models\Slider;
use App\Models\Blog;
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
}
