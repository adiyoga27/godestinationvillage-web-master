<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\BlogCollection;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\Events\EventCollection;
use App\Http\Resources\Events\EventResource;
use App\Http\Resources\Homestay\HomestayCollection;
use App\Http\Resources\Homestay\HomestayResource;
use App\Http\Resources\Packages\PackageCollection;
use App\Http\Resources\Packages\PackageResource;
use App\Http\Resources\Village\VillageCollection;
use App\Http\Resources\Village\VillageDetailCollection;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Homestay;
use App\Models\Order;
use App\Models\Package;
use App\Models\VillageDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageControllerApi extends Controller
{

    public function __construct(
        public Blog $blog,
        public Homestay $homestay,
        public Event $event,
        public Package $tour,
        public VillageDetail $village,
        public Order $order
    ) {
    }
    public function blog(Request $request)
    {

        $blogs = $this->blog->orderBy('id', 'DESC')->paginate($request->per_page);

        if (!empty($request->keyword)) {
            $blogs = $this->blog->orderBy('id', 'DESC')->where('post_title', 'like', '%' . $request->keyword . '%')->paginate($request->per_page);
        }
        return response()->json(new BlogCollection($blogs));
    }


    public function detailBlog(Request $request, $id)
    {
        $blog = $this->blog->where('id', $id)->first();
        if (!$blog) {
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
        if (!empty($request->keyword)) {
            $homestays = $this->homestay->orderBy('id', 'DESC')->where('name', 'like', '%' . $request->keyword . '%')->paginate($request->per_page);
        }
        return response()->json(new HomestayCollection($homestays));
    }

    public function detailHomestay(Request $request, $id)
    {
        $homestay = $this->homestay->where('id', $id)->first();
        if (!$homestay) {
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
        if (!empty($request->keyword)) {
            $events = $this->event->orderBy('id', 'DESC')->where('name', 'like', '%' . $request->keyword . '%')->paginate($request->per_page);
        }
        return response()->json(new EventCollection($events));
    }

    public function detailEvent(Request $request, $id)
    {
        $event = $this->event->where('id', $id)->first();
        if (!$event) {
            return response()->json([
                'data' => [],
                'status' => FALSE,
                'messages' => 'Your data not found'
            ]);
        }
        return response()->json([
            'data' => new EventResource($event),
            'status' => TRUE,
            'messages' => 'Success'
        ]);
    }

    public function tour(Request $request)
    {
        $category = $request->input('category');
        if ($category == 'popular') {
            $orders = DB::table('orders')->select('package_id', DB::raw('count(*) as total'))->groupBy('package_id')->orderBy('total', 'DESC')->pluck('package_id');
            $tours = $this->tour->whereIn('id', $orders)->where('is_active', 1)->orderBy('id', 'DESC')->paginate($request->per_page);
        } else if ($category == 'history') {
            $tours = $this->tour->where('is_active', 1)->orderBy('id', 'DESC')->paginate($request->per_page);
        } elseif ($category == 'newest') {
            $tours = $this->tour->where('is_active', 1)->orderBy('id', 'DESC')->paginate($request->per_page);
        } else {
            $tours = $this->tour->where('is_active', 1)->orderBy('id', 'DESC')->paginate($request->per_page);
        }


        if (!empty($request->keyword)) {
            $tours = $this->tour->orderBy('id', 'DESC')->where('name', 'like', '%' . $request->keyword . '%')->paginate($request->per_page);
        }
        return response()->json(new PackageCollection($tours));
    }

    public function detailTour(Request $request, $id)
    {
        $tour = $this->tour->where('id', $id)->first();
        if (!$tour) {
            return response()->json([
                'data' => [],
                'status' => FALSE,
                'messages' => 'Your data not found'
            ]);
        }
        return response()->json([
            'data' => new PackageResource($tour),
            'status' => TRUE,
            'messages' => 'Success'
        ]);
    }

    public function village(Request $request)
    {
        $villages = $this->village->where('village_address', '<>', '-')->whereHas('user', function ($q) {
            $q->where('role_id', 2);
        })->orderBy('id', 'DESC')->paginate($request->per_page);
        if (!empty($request->keyword)) {
            $villages = $this->village->whereHas('user', function ($q) {
                $q->where('role_id', 2);
            })->orderBy('id', 'DESC')->where('village_address', '<>', '-')->where('village_name', 'like', '%' . $request->keyword . '%')->paginate($request->per_page);
        }
        return response()->json(new VillageCollection($villages));
    }
}
