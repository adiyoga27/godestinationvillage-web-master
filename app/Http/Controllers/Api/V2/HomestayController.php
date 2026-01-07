<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Homestay\CategoryHomestayResource;
use App\Http\Resources\V2\Homestay\HomestayCollection;
use App\Http\Resources\V2\Homestay\HomestayResource;
use App\Models\CategoryHomestay;
use App\Models\Homestay;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    public function categories(Request $request) {
        $data = CategoryHomestay::all();
        return CategoryHomestayResource::collection($data)->additional([
            'status' => true,
            'message' => 'Success'
        ]);
    }
    public function index(Request $request) {
        $data = Homestay::orderBy('id', 'DESC');
        if($request->category_id){
            $data = $data->where('category_id', $request->category_id);
        }
        $data = $data->paginate($request->per_page);
        return new HomestayCollection($data);
    }
    
    public function show(Request $request, $slugs) {
        $data = Homestay::where('slug', $slugs)->first();
        return response()->json([
            'status' => true,
            'message' => "Success",
            'data' => new HomestayResource($data)
        ]);
    }
}
