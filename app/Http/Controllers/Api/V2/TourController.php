<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Tours\CategoryTourResource;
use App\Http\Resources\V2\Tours\TourCollection;
use App\Http\Resources\V2\Tours\TourResource;
use App\Models\CategoryPackage;
use App\Models\Package;
use App\Models\User;
use App\Models\VillageDetail;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function popularTours() {
        $data = Package::where('price', '>', 0)->orderBy('id', 'DESC')->paginate(5);
        return new TourCollection($data);
    }
    public function categories(Request $request) {
        $users = User::where('role_id', 2)->pluck('id');
        $data = VillageDetail::whereIn('user_id', $users)->get();
        return CategoryTourResource::collection($data)->additional([
            'status' => true,
            'message' => 'Success'
        ]);
    }
    public function index(Request $request) {
        $data = Package::where('price', '>', 0)->orderBy('id', 'DESC')->paginate($request->per_page);
        return new TourCollection($data);
    }
    
    public function show(Request $request, $slugs) {
        $data = Package::where('slug', $slugs)->first();
        return response()->json([
            'status' => true,
            'message' => "Success",
            'data' => new TourResource($data)
        ]);
    }
}
