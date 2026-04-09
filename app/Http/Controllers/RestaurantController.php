<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Resources\CityResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\RestaurantResource;
use App\Models\City;
use App\Models\Item;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RestaurantController extends Controller
{
  public function create()
  {
    return Inertia::render("Restaurant/Create", [
      'cities' => CityResource::collection(
        City::all()
      )
    ]);
  }


  public function store(StoreRestaurantRequest $request)
  {
    $fields = $request->validated();

    if ($request->hasFile('logo')) {
      $fields['logo'] = Storage::disk('public')->put('restaurant_logo', $request->logo);
    }

    Restaurant::create($fields);
    return Redirect::route('dashboard');
  }


  public function show(Restaurant $restaurant)
  {
    return Inertia::render('Items/Index', [
      'items' => ItemResource::collection(
        Item::where('restaurant_id', $restaurant->id)->get()
      ),
      'restaurant' => $restaurant,
    ]);
  }


  public function edit(Restaurant $restaurant)
  {
    return Inertia::render("Restaurant/Edit", [
      'restaurant' => new RestaurantResource(
        Restaurant::where('id', $restaurant->id)->first()
      )
    ]);
  }


  public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
  {
    $getRestaurant = Restaurant::findOrFail($restaurant->id);
    $fields = $request->validated();

    if ($request->hasFile('logo') && $request->logo !== null) {
      if ($getRestaurant['logo'] !== null) {
        Storage::disk('public')->delete($getRestaurant['logo']);
      }

      $fields['logo'] = Storage::disk('public')->put('restaurant_logo', $request->logo);
    }

    if ($request->logo === null) {
      $fields['logo'] = $getRestaurant['logo'];
    }

    $restaurant->update($fields);
    return Redirect::route('dashboard');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Restaurant $restaurant)
  {
    //
  }
}
