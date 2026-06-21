<?php

namespace App\Services;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UpdateUser
{
    public function update(ProfileUpdateRequest $request)
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
}
