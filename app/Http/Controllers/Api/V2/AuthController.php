<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AuthResource;
use App\Http\Resources\V2\UserResource;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use JsonResponseTrait;

    public function login(Request $request)
    {
        $attemps = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if($attemps){
            $users = Auth::user();
            $data = new AuthResource($users, $users->createToken($request->email)->plainTextToken);
            return $this->responseDataMessage($data);

        }
       
        return $this->errorResponseMessage('Email dan Password Salah', 401);


    }

    public function registration(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'country' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'avatar' => 'required',
        ]);

        try {
            $imageName = time().'.'.$request->avatar->extension();
            $uploadedImage = $request->avatar->move(public_path('storage/users'), $imageName);
            $imagePath = 'users/' . $imageName;
    
    
            $result = User::create([
                'name' => $request->name,
                'email' =>  $request->email,
                'password' => Hash::make( $request->password),
                'country' =>  $request->country,
                'role_id' =>  3,
                'phone' =>  $request->phone,
                'address' =>  $request->address,
                'avatar' => $imagePath
            ]);

            $attemps = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if($attemps){
                $users = Auth::user();
                $data = new AuthResource($users, $users->createToken($request->email)->plainTextToken);
                return $this->responseDataMessage($data, "Berhasil Membuat Account");
            }
        } catch (\Throwable $th) {
            throw $th;
            return $this->responseErrorDataMessage(['error' => 'Unauthorised'], 'Gagal melakukan registrasi silahkan ulangi beberapa saat lagi.');

        }
      
      
    }
}
