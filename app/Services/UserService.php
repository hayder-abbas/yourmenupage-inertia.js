<?php

namespace App\Services;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function userUpdate(ProfileUpdateRequest $request)
    {
        $user = User::findOrFail(Auth::id());
        $fields = $request->validated();
        $oldImg = $user->user_image;
        $newImg = null;

        try {
            if ($request->hasFile('user_image')) {
                // 1. Store new image (may throw exception)
                $newImg = $request->file('user_image')->store('user_image', 'public');
                $fields['user_image'] = $newImg;
            } else {
                // 2. If no new image, remove the key to keep existing one
                unset($fields['user_image']);
            }

            // 3. Update the user (database operation)
            $request->user()->fill($fields);
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
            $request->user()->save();

            // 4. Delete old image only after successful update
            if ($newImg && $oldImg) {
                Storage::disk('public')->delete($oldImg);
            }
        } catch (\Exception $ex) {
            if ($newImg) {
                Storage::disk('public')->delete($newImg);
            }
            throw $ex;
        }
    }


    public function deleteUser(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        try {
            if ($user->user_image) {
                Storage::disk('public')->delete($user->user_image);
            }
        } catch (\Exception $ex) {
            Log::warning('Failed to delete user image: ' . $ex->getMessage());
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
