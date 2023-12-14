<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function Callback()
    {
        try{
            $socialUser = Socialite::driver('google')->user();
                $user = User::where('google_id', $socialUser->id)->first();
                    if (!$user) {
                        $newUser = User::create([
                            'name' => $socialUser->name,
                            'email' => $socialUser->email,
                            'google_id' => $socialUser->getId(),
                        ]);
                        Auth::login($newUser);
                        return redirect()->route('dashboard');
                    }else{
                        Auth::login($user);
                        return redirect()->route('dashboard');
                    }
                    }
                catch (\Throwable $th){
                    dd('some thing wrong !'.$th->getMessage());
                                        }
    }
}
