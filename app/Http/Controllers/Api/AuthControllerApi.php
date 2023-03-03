<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\AuthServices;
use App\Services\UserService;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthControllerApi extends Controller
{
    use JsonResponseTrait;

    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if($auth) {
            $user = collect(new UserResource(Auth::user()));
            $user['token'] = Auth::user()->createToken('token')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Login Success',
                'data' => $user
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Login Failed',
        ], 401);
    }

    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'country' => 'required',
        ]);
        try {
       
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'country' => $request->country,
            ]);
            $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            $user = collect(new UserResource(Auth::user()));
            $user['token'] = Auth::user()->createToken('token')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
       

       
        
    }
}
