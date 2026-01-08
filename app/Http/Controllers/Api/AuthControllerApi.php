<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthServices;
use App\Services\UserService;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Auth;

class AuthControllerApi extends Controller
{
    use JsonResponseTrait;
    public function __construct(AuthServices $authServices, UserService $userService)
    {
        $this->userServices = $userService;
        $this->authServices = $authServices;
    }
    
    public function login(Request $request)
    {
        if ($this->authServices->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user =  $this->authServices->user();
            $success['id'] =  $user->id;
            $success['email'] =  $user->email;
            $success['name'] =  $user->name;
            $success['phone'] =  $user->phone;
            $success['country'] =  $user->country;
            $success['address'] =  $user->address;
            $success['role'] =  $user->role_id;
            $success['avatar'] =  url('storage/users')."/".$user->avatar;
            $success['token'] =  $user->createToken($user->email)->plainTextToken;

            return $this->responseDataMessage($success);
        } 

        return $this->errorResponseMessage('Email dan Password Salah', 401);


    }

    public function registration(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $result = $this->userServices->registration($request);
        if($result == true){
            return $this->responseDataMessage($result);
        }
        return $this->responseErrorDataMessage(['error' => 'Unauthorised'], 'Email Telah Terdaftar.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password_new' => 'required',
            'password_confirm' => 'required|same:password_new'
        ]);

        $user = Auth::user();
        $result = User::where('id', $user->id)->update([
            'password' => bcrypt($request->password_new)
        ]);
        if($result == true){
            return $this->successResponseMessage('Password Berhasil Diubah');
        }
    }

    public function loginSosmed(Request $request)
    {
        $request->validate([
            'provider' => 'required',
            'provider_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user){
           
            //create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => 3,
                'is_active' => 1,
                'password' => bcrypt('godestinationvillage'),
                'provider' => $request->provider,
                'provider_id' => $request->provider_id,
            ]);
        }
            $success['id'] =  $user->id;

        $success['email'] =  $user->email;
        $success['name'] =  $user->name;
        $success['phone'] =  $user->phone;
        $success['country'] =  $user->country;
        $success['address'] =  $user->address;
        $success['role'] =  $user->role_id;
        $success['avatar'] =  url('storage/users')."/".$user->avatar;
        $success['token'] =  $user->createToken($user->email)->plainTextToken;

        return $this->responseDataMessage($success);
    }
}
