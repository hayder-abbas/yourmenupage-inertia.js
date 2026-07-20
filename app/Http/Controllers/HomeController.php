<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'restaurants' => RestaurantResource::collection(
                Restaurant::query()
                    ->select('id', 'rest_name', 'location')
                    ->when($request->input('search'), function ($query, $search) {
                        $query->where('rest_name', 'like', '%' . trim($search) . '%');
                    })->limit(10)->get()
            ),
            'filters' => $request->only(['search']),
        ]);
    }
}
