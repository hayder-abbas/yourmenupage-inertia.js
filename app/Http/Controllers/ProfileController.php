<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\DeleteUser;
use App\Services\UpdateUser;
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


    public function update(ProfileUpdateRequest $request, UpdateUser $service): RedirectResponse
    {
        $service->update($request);
        return redirect('/profile')->with('status', 'profile-updated');
    }


    public function destroy(Request $request, DeleteUser $service): RedirectResponse
    {
        $service->delete($request);
        return redirect('login')->with('status', 'user-deleted');
    }


    public function resetProfileImg()
    {
        $user = User::findOrFail(Auth::id());
        if ($user->user_image) {
            User::where('id', Auth::id())->update(['user_image' => '']);
            Storage::disk('public')->delete($user->user_image);
        }
        return redirect('/profile')->with('status', 'profile-image-deleted');
    }
}
