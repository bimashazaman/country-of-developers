<?php

namespace App\Http\Controllers\RESTAPIs;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Laravel\Socialite\Facades\Socialite;

class AuthRestApiController extends Controller
{
    use RegistersUsers;

    use Notifiable;


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Reactivate the user if they are inactive
            if ($user->status === 'inactive') {
                $user->status = 'active';
                $user->save();
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => $user,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'message' => 'Invalid login credentials.',
        ], 401);
    }


    public function register(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'username' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:8|max:255',
            'age' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->age = $request->input('age');
        $user->gender = $request->input('gender');
        $user->role = 'user';
        $user->status = 'active';
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->sendEmailVerificationNotification();
        $user->notify(new UserRegisteredNotification());

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            // you can handle login or account creation here based on $user details.
            // for example: find user by email or create a new user

            // here is an example of how you might create a new user or get existing one:
            $appUser = User::firstOrCreate(
                ['email' => $user->getEmail()],
                ['name' => $user->getName(), 'password' =>  Hash::make($user->token)]
            );


            // $appUser = User::firstOrCreate(
            //     ['email' => $user->email],
            //     [
            //         'name' => $user->name,
            //         'email' => $user->email,
            //         'avatar' => $user->avatar,
            //         'password' => Hash::make($user->token),
            //     ]

            // );

            // login the user
            Auth::login($appUser, true);

            $token = $appUser->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => $appUser,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Google login failed, please try again.'
            ], 400);
        }
    }


    //facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }


    public function searchUsers(Request $request)
    {
        $query = User::query();

        // Search by name
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Search by email
        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        // Search by ID
        if ($request->has('id')) {
            $query->where('id', '=', $request->input('id'));
        }

        // Search by created_at
        if ($request->has('created_at')) {
            $query->where('created_at', '=', $request->input('created_at'));
        }

        // Paginate the results
        $perPage = $request->has('per_page') ? (int) $request->input('per_page') : 10;
        $results = $query->paginate($perPage);

        return response()->json([
            'data' => $results->items(),
            'meta' => [
                'total' => $results->total(),
                'per_page' => $perPage,
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
            ],
        ]);
    }
}
