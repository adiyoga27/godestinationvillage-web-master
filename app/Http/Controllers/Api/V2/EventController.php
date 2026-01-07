<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Event\CategoryEventResource;
use App\Http\Resources\V2\Event\EventCollection;
use App\Http\Resources\V2\Event\EventResource;
use App\Models\CategoryEvent;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function categories(Request $request) {
        $data = CategoryEvent::all();
        return CategoryEventResource::collection($data)->additional([
            'status' => true,
            'message' => 'Success'
        ]);
    }
    public function index(Request $request) {
        $data = Event::orderBy('id', 'DESC');
        if($request->category_id){
            $data = $data->where('category_id', $request->category_id);
        }
        $data = $data->paginate($request->per_page);

        return new EventCollection($data);
    }
    
    public function show(Request $request, $slugs) {
        $data = Event::where('slug', $slugs)->first();
        return response()->json([
            'status' => true,
            'message' => "Success",
            'data' => new EventResource($data)
        ]);
    }
 
}
