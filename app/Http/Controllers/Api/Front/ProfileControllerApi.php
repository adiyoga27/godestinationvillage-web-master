<?php

namespace App\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\JsonResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileControllerApi extends Controller
{
    use JsonResponseTrait;
    public function index()
    {
        if (Auth::check()) {

            $userId = Auth::id();

            $data['user'] = User::where('id', $userId)

                ->first();

        }
        return $this->responseDataMessage($data);
    }
}
