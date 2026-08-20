<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return inertia("Dashboard", [
            "restaurant" => Auth::user()->restaurant
                ? new RestaurantResource(Auth::user()->restaurant)
                : null,
            "canCreateRestaurant" => Gate::allows("createRestaurant", Auth::user()),
        ]);
    }
}
