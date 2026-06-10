<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __construct(
        private UserService $service
    ) {}


    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->service->userUpdate($request);
        return redirect()->back()->with('status', 'profile-updated');
    }


    public function destroy(Request $request): RedirectResponse
    {
        $this->service->deleteUser($request);
        return to_route('login')->with('status', 'user-deleted');
    }


    public function resetProfileImg()
    {
        $user = User::findOrFail(Auth::id());

        if ($user->user_image) {
            User::where('id', Auth::id())->update(['user_image' => '']);
            Storage::disk('public')->delete($user->user_image);
        }

        return redirect()->back()->with('status', 'profile-image-deleted');
    }
}
