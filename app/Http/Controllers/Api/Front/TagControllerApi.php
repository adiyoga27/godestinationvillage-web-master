<?php

namespace App\Http\Controllers\Api\Front;

use App\CategoryPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Packages\PackageCollection;
use App\Http\Resources\Tag\TagCategoryCollection;
use App\Http\Resources\Tag\TagCollection;
use App\Package;
use App\Tag;
use App\Traits\JsonResponseTrait;

class TagControllerApi extends Controller
{
    use JsonResponseTrait;

    public function view()
    {
        $data = Tag::all();
        return $this->responseCollection(new TagCategoryCollection($data));
    }
    public function viewBy($id)
    {
        $result = Package::with(['category', 'village', 'user', 'tag'])
        ->whereHas('user', function ($query) {
            return $query->where('users.role_id', '=', 2)
                            ->where('users.is_active', '=', 1); })
            ->whereHas('village', function ($query) {
                return $query->whereNotNull('village_details.id'); })
                ->whereHas('tag', function ($query) use($id){
                    return $query->where('category_packages.tag_id', '=', $id); })
               
            ->orderBy('id', 'desc')->paginate();
           
            $data = new PackageCollection($result);

            return $this->responseCollection($data);
    }
}
