<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\V2\Tours\TourCollection;
use App\Http\Resources\Village\VillageCollection;
use App\Http\Resources\Village\VillageDetailCollection;
use App\Http\Resources\Village\VillageDetailResource;
use App\Http\Resources\Village\VillageResource;
use App\Models\Package;
use App\Traits\JsonResponseTrait;
use App\Models\User;
use App\Models\VillageDetail;

class VillageControllerApi extends Controller
{
    use JsonResponseTrait;
    public function index()
    {
        $data = VillageDetail::paginate(5);
        $result = new VillageCollection($data);
        return $this->responseCollection($result);
    }

    public function show($id)
    {

        // $data = User::with('village_detail')->whereHas('village_detail', function ($query) use ($id) {
        //     return $query->where('village_details.id', '=', $id);
        // })->paginate(5);

        $data = User::with('village_detail')->where('id', $id)->get();
        
        
        $result = new VillageDetailCollection($data);
        return $this->responseCollection($result);

    }

    public function tourVillages($slug)
    {
        $data = VillageDetail::where('slug', $slug)->first();
          $data = Package::where('is_active', 1)->where('village_id', $data->id)->orderBy('id', 'DESC')->paginate(5);
        return new TourCollection($data);
      
    }

}
