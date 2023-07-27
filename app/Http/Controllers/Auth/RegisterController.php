<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{


    use RegistersUsers;
    use Notifiable;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'day' => ['nullable', 'string', 'max:255'],
            'month' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:255'],
        ]);
    }


    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'day' => $data['day'],
            'month' => $data['month'],
            'year' => $data['year'],
            'gender' => $data['gender'],
            'role' => 'user',
            'status' => 'active',
            'password' => Hash::make($data['password']),
        ]);

        $user->sendEmailVerificationNotification();
        $user->notify(new UserRegisteredNotification($user));

        return $user;
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }


    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }


    private function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $data->name,
                'email' => $data->email,
                'provider_id' => $data->id,
                'avatar' => $data->avatar,
                'provider' => $data->provider,
                'password' => Hash::make($data['password']), // This can be null if you prefer
            ]);
        }

        Auth::login($user);
    }
}
