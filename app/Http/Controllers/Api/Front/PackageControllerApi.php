<?php
namespace App\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Packages\PackageCollection;
use App\Http\Resources\Packages\PackageDetailCollection;
use App\Http\Resources\Packages\PackageRecentCollection;
use App\Http\Resources\Packages\PackageRecentResource;
use App\Http\Resources\Packages\PackageResource;
use App\Package;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Storage;

class PackageControllerApi extends Controller
{
    use JsonResponseTrait;
    public function popular()
    {
       
        $result = Package::with(['category', 'village', 'user'])
                    ->whereHas('user', function ($query) {
                        return $query->where('users.role_id', '=', 2)->where('users.is_active', '=', 1); })
                        ->whereHas('village', function ($query) {
                            return $query->whereNotNull('village_details.id'); })
                            ->where('packages.is_active', '=', 1)
                        ->orderBy('desc')->paginate(5);
        $data = new PackageCollection($result);
    
        return $this->responseCollection($data);
    }

    public function search($keyword)
    {

        $result = Package::with(['category', 'village', 'user'])
        ->whereHas('user', function ($query) {
            return $query->where('users.role_id', '=', 2)->where('users.is_active', '=', 1); })
            ->whereHas('village', function ($query) use($keyword) {
                return $query->whereNotNull('village_details.id')
                            ->where('name', 'like', '%' . $keyword.'%')
                
                ; })
            ->orderBy('desc')->paginate(8);
        $data = new PackageCollection($result);

return $this->responseCollection($data);
    }

    public function recentPackages()
    {
        $result = Package::with(['category', 'village', 'user'])
                    ->whereHas('user', function ($query) {
                        return $query->where('users.role_id', '=', 2)
                                        ->where('users.is_active', '=', 1); })
                        ->whereHas('village', function ($query) {
                            return $query->whereNotNull('village_details.id'); })
                            ->where('packages.is_active', '=', 1)
                        ->orderBy('id', 'desc')->paginate(8);
        $data = new PackageCollection($result);
    
        return $this->responseCollection($data);


        // $data = Package::select('packages.id as id','packages.name', 'categories.name as cat_name', 'village_details.village_name as vil_name', 'default_img')
        //             ->join('users', 'users.id', 'user_id')
        //             ->join('village_details', 'users.id', 'village_details.user_id')
        //             ->join('categories', 'categories.id', 'category_id')
        //             ->where('users.is_active', '1')
        //             ->where('packages.is_active', '1')
        //             ->where('users.role_id', '2')
        //             ->orderBy('packages.id', 'desc')
        //             ->paginate(5);
        // return $this->responseCollection(new PackageRecentCollection($data));
    }

    public function bestPackages()
    {
        $id = 8;
        $result = Package::with(['category', 'village', 'user'])
        ->whereHas('user', function ($query) {
            return $query->where('users.role_id', '=', 2)->where('users.is_active', '=', 1); })
            ->whereHas('village', function ($query) {
                return $query->whereNotNull('village_details.id'); })
                ->where('user_id', '=', $id)
            ->orderBy('desc')->paginate(8);
        $data = new PackageCollection($result);

        return $this->responseCollection($data);

    }

    public function detailPackage($id)
    {
      
        $result = Package::with(['category', 'village', 'user'])->where('packages.id', '=', $id)
        ->whereHas('user', function ($query) {
            return $query->where('users.role_id', '=', 2)
                            ->where('users.is_active', '=', 1); })
            ->whereHas('village', function ($query) {
                return $query->whereNotNull('village_details.id'); })
               
            ->orderBy('id', 'desc')->paginate();
           
            $data = new PackageDetailCollection($result);

            return $this->responseCollection($data);
    }
}
