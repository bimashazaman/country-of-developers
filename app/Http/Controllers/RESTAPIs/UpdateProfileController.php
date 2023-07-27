<?php

namespace App\Http\Controllers\RESTAPIs;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UpdateProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->birthday = $request->input('birthday');
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user,
        ], 200);
    }

    public function updateEmailAndMobile(Request $request)
    {
        $user = $request->user();
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->save();

        return response()->json([
            'message' => 'Email and mobile updated successfully',
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect',
            ], 422);
        }

        if ($newPassword !== $confirmPassword) {
            return response()->json([
                'message' => 'New password and confirm password do not match',
            ], 422);
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }

    public function updateNameAndUsername(Request $request)
    {
        $user = $request->user();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->bio = $request->input('bio');
        $user->save();

        return response()->json([
            'message' => 'Name, username, and bio updated successfully',
            'user' => $user,
        ]);
    }

    //update cover image

    public function updateCover(Request $request)
    {
        try {
            $user = $request->user();
            $validatedData = $request->validate([
                'cover' => 'image|mimes:jpeg,png,jpg|max:2048|required',
            ]);

            $uploadsPath = public_path('covers');
            if (!file_exists($uploadsPath)) {
                mkdir($uploadsPath, 0777, true);
            }

            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                Log::info('Cover file received.', ['cover' => $cover]);

                $fileName = time() . '.' . $cover->getClientOriginalExtension() ?? 'png';
                $cover->move($uploadsPath, $fileName);
                $validatedData['cover'] = $fileName;

                if ($user->cover && file_exists($uploadsPath . '/' . $user->cover)) {
                    // Delete previous cover file
                    unlink($uploadsPath . '/' . $user->cover);
                }
            } else {
                $validatedData['cover'] = $user->cover;
            }

            $user->update($validatedData);
            Log::info('User updated.', ['user' => $user]);

            return response()->json([
                'message' => 'Cover image updated successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            Log::error('An error occurred while updating the cover image.', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred while updating the cover image.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // priofile image upload

    public function updateAvatar(Request $request)
    {
        try {
            $user = $request->user();
            $validatedData = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg|max:2048|required',
            ]);

            $uploadsPath = public_path('avatars');
            if (!file_exists($uploadsPath)) {
                mkdir($uploadsPath, 0777, true);
            }

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                Log::info('Avatar file received.', ['avatar' => $avatar]);

                $fileName = time() . '.' . $avatar->getClientOriginalExtension() ?? 'png';
                $avatar->move($uploadsPath, $fileName);
                $validatedData['avatar'] = $fileName;

                if ($user->avatar && file_exists($uploadsPath . '/' . $user->avatar)) {
                    // Delete previous avatar file
                    unlink($uploadsPath . '/' . $user->avatar);
                }
            } else {
                $validatedData['avatar'] = $user->avatar;
            }

            $user->update($validatedData);
            Log::info('User updated.', ['user' => $user]);

            return response()->json([
                'message' => 'Profile image updated successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            Log::error('An error occurred while updating the profile image.', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred while updating the profile image.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    //search user

    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('status', '!=', 'inactive')
            ->where(function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->get();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'users' => $users,
        ]);
    }



    public function deactivate(Request $request)
    {
        $user = $request->user();

        // Update user's status to 'inactive'
        $user->status = 'inactive';
        $user->save();

        return response()->json([
            'message' => 'Account deactivated successfully',
        ]);
    }

    public function reactivate(Request $request)
    {
        $user = $request->user();

        // Update user's status back to 'active'
        $user->status = 'active';
        $user->save();

        return response()->json([
            'message' => 'Account reactivated successfully',
        ]);
    }
}
