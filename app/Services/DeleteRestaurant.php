<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteRestaurant
{
    public function delete(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        DB::transaction(function () use ($restaurant) {
            $restaurant->delete();
            $user = User::findOrFail(Auth::id());
            $user->update(['has_restaurant' => 0]);
        });

        if ($restaurant->rest_logo) {
            Storage::disk('public')->delete($restaurant->rest_logo);
        }

        $itemImageDir = 'item_image/' . $restaurant->id;

        if (Storage::disk('public')->exists($itemImageDir)) {
            Storage::disk('public')->deleteDirectory($itemImageDir);
        }
    }
}
