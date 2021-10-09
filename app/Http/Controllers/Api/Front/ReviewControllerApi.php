<?php

namespace App\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Review\ReviewCollection;
use App\Review;
use App\Traits\JsonResponseTrait;

class ReviewControllerApi extends Controller
{
    use JsonResponseTrait;
    public function index()
    {
        $data = Review::with(['users', 'package'])->paginate(5);
        $result = new ReviewCollection($data);
        return $this->responseCollection($result);
    }
    public function create()
    {
        # code...
    }
}
