<?php

namespace App\Http\Controllers\Api\Front;

use App\CategoryPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use App\Traits\JsonResponseTrait;

class CategoryPackageControllerApi extends Controller
{
    use JsonResponseTrait;
    public function index()
    {
        $data = Tag::all();
        return $this->responseDataMessage($data);
    }

    public function show($id)
    {
        $data = CategoryPackage::all();
        return $this->responseDataMessage($data);
    }
}
