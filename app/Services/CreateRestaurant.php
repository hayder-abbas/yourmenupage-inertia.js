<?php

namespace App\Services;

use App\Http\Requests\StoreRestaurantRequest;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

            $newRestaurant = DB::transaction(function () use ($fields) {
                $newRest = Restaurant::create($fields);
                $user = User::findOrFail(Auth::id());
                $user->update(['has_restaurant' => 1]);

                return $newRest;
            });
        } catch (\Exception $ex) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            throw $ex;
        }

        return $newRestaurant;
    }
}
