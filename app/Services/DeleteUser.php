<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteUser
{
    public function delete(Request $request)
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
