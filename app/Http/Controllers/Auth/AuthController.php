<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {

        $user = Socialite::driver($provider)->user();
    
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect('/');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $id = $user->id();
        $nick = $user-> $user->getNickname();
        $name = $user->getName();
        $email = $user->getEmail();
        $avatar = $user->getAvatar();
        $authUser = User::where('provider_id', $id)->first();
        if ($authUser) {
            return $authUser;
        }
        else{
            $data = User::create([
                'name'     => $name,
                'email'    => !empty($email)? $email : '' ,
                'provider' => $provider,
                'provider_id' => $id
            ]);
            return $data;
        }
    }
}
