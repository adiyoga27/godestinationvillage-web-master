<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Village\VillageCollection;
use App\Http\Resources\Village\VillageDetailCollection;
use App\Http\Resources\Village\VillageDetailResource;
use App\Http\Resources\Village\VillageResource;
use App\Traits\JsonResponseTrait;
use App\Models\User;
use App\Models\VillageDetail;

class VillageControllerApi extends Controller
{
    use JsonResponseTrait;
    public function index()
    {
        $data = User::with('village_detail')
                    ->where('role_id', '2')
                    ->where('is_active', '1')
                    ->paginate(5);
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

}
