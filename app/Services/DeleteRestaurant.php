<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteRestaurant
{
    public function delete(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $restaurant->delete();

        if ($restaurant->rest_logo) {
            Storage::disk('public')->delete($restaurant->rest_logo);
        }

        $itemImageDir = 'item_image/' . $restaurant->id;

        if (Storage::disk('public')->exists($itemImageDir)) {
            Storage::disk('public')->deleteDirectory($itemImageDir);
        }
    }
}
