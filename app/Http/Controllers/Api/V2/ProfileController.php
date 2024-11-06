<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => new UserResource(Auth::user())
    ]);
    }
}
