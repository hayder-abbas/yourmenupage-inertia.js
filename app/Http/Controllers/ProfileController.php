<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());
        $fields = $request->validated();

        if ($request->hasFile('user_image')) {
            if ($user['user_image'] !== null) {
                Storage::disk('public')->delete($user['user_image']);
            }
            $fields['user_image'] = Storage::disk('public')
                ->put('user_image', $request->user_image);
        }

        if ($fields['user_image'] === null) {
            $fields['user_image'] = $user['user_image'];
        }

        $request->user()->fill($fields);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->back()->with('status', 'profile-updated');
    }


    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login')->with('status', 'user-deleted');
    }
}
