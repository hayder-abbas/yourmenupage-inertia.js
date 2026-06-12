<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Http\Resources\RestaurantResource;
use App\Models\City;
use App\Models\Restaurant;
use Inertia\Inertia;

class CityController extends Controller
{
    public function index()
    {
        return Inertia::render('City/Index', [
            'cities' => CityResource::collection(
                City::all()
            )
        ]);
    }


    public function show(City $city)
    {
        return Inertia::render('City/Show', [
            'restaurants' => RestaurantResource::collection(
                Restaurant::where('city_id', $city->id)->paginate(20)
            ),
            'cityName' => $city->city_name
        ]);
    }
}
