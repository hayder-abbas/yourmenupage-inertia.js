<?php

namespace App\Services;

use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantService
{
    public function createRestaurant(StoreRestaurantRequest $request)
    {
        $fields = $request->validated();
        $newRestaurant = null;
        $logoPath = null;

        try {
            if ($request->hasFile('rest_logo')) {
                $logoPath = $request->file('rest_logo')
                    ->store('restaurant_logo', 'public');
                $fields['rest_logo'] = $logoPath;
            }

            $newRestaurant = Restaurant::create($fields);
        } catch (\Exception $ex) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            throw $ex;
        }

        return $newRestaurant;
    }


    public function updateRestaurant(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $fields = $request->validated();
        $oldLogo = $restaurant->rest_logo; // capture before update
        $newLogo = null;

        try {
            if ($request->hasFile('rest_logo')) {
                // 1. Store new logo (may throw exception)
                $newLogo = $request->file('rest_logo')
                    ->store('restaurant_logo', 'public');
                $fields['rest_logo'] = $newLogo;
            } else {
                // 2. If no new logo, remove the key to keep existing one
                unset($fields['rest_logo']);
            }
            // 3. Update the restaurant (database operation)
            $restaurant->update($fields);

            // 4. Delete old logo only after successful update
            if ($newLogo && $oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
        } catch (\Exception $ex) {
            // If anything failed after storing the new logo, clean it up
            if ($newLogo) {
                Storage::disk('public')->delete($newLogo);
            }
            throw $ex;
        }
    }


    public function destroyRestaurant(Request $request, Restaurant $restaurant)
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
