<?php
namespace App\Services;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;

class AuthServices
{
    public function attempt($payload)
    {
        return Auth::attempt($payload);
    }

    public function user()
    {
        return Auth::user();
    }

    public function createToken($payload)
    {
       return $payload->createToken('MyApp')->accessToken;
    }


}