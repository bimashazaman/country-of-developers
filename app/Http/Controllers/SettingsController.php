<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index($user_id)
    {
        $user = User::find($user_id);
        $friends = $user->friends;
        $pages = $user->pages;
        return view('settings.index', compact('user', 'friends', 'pages'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'nullable|string|in:user,admin',
            'status' => 'nullable|string|in:active,inactive',
            'bio' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'birthday' => 'nullable|date',
        ]);

        $uploadsPath = public_path('avatars');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move($uploadsPath, $fileName);
            $validatedData['avatar'] = $fileName;
            if ($user->avatar) {
                Storage::delete('avatars/' . $user->avatar);
            }
        }
        $uploadsPath = public_path('covers');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $fileName = time() . '_' . $cover->getClientOriginalName();
            $cover->move($uploadsPath, $fileName);
            $validatedData['cover'] = $fileName;
            if ($user->cover) {
                Storage::delete('covers/' . $user->cover);
            }
        }
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }
        $user->update($validatedData);
        return redirect()->back()->with('success', 'User updated successfully.');
    }


    //password update
    public function updateUserPassword(Request $request)
    {
        $user = $request->user();
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');



        if (!Hash::check($currentPassword, $user->password)) {
            session()->flash('error', 'Current password is incorrect.');
            return redirect()->back();
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        session()->flash('success', 'Password updated successfully.');

        //log the user out
        auth()->logout();

        return redirect()->route('login');
    }


    //view file for update password
    public function viewPassword($id)
    {
        $user = User::find($id);
        $friends = $user->friends;
        $pages = $user->pages;
        return view('settings.password', compact('user', 'friends', 'pages'));
    }


    public function deactivateAccount(Request $request)
    {
        $user = $request->user();

        // Update user's status to 'inactive'
        $user->status = 'inactive';
        $user->save();

        //log the user out
        auth()->logout();

        return redirect()->route('login');
    }

    //deactivate view page
    public function viewDeactivate($id)
    {
        $user = User::find($id);
        $friends = $user->friends;
        $pages = $user->pages;
        return view('settings.deactivate', compact('user', 'friends', 'pages'));
    }
}
