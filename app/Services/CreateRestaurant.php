<?php

namespace App\Services;

use App\Http\Requests\StoreRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;

class CreateRestaurant
{
    public function create(StoreRestaurantRequest $request)
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
}
