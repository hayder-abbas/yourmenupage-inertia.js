<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @todo: Search/Filter Items **/
        // $query = Item::query();
        // $request->validate([
        //     'field' => ['in:id,item_title,item_price,restaurant_id,category_id'],
        //     'direction' => ['in:asc,desc']
        // ]);
        // if ($request->search) {
        //     $query->where('item_title', 'like', "$request->search%");
        // }
        // if ($request->has(['field', 'direction'])) {
        //     $query->orderBy($request->field, $request->direction);
        // }
        $restaurant = Restaurant::where("user_id", Auth::id())->first();

        return inertia("Dashboard", [
            "restaurant" => $restaurant
                ? new RestaurantResource($restaurant)
                : null,
            "canCreateRestaurant" => Gate::allows("createRestaurant", Auth::user()),
        ]);
    }
}
