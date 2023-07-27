<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{



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

        //if any error occurs, it will be redirected to the previous page with the error message


        return redirect()->route('profile.index', $user->id)->with('success', 'Profile updated successfully.');
    }
}
