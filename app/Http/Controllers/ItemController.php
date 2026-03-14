<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\RestaurantResource;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ItemController extends Controller
{
  public function index()
  {
    //
  }


  public function create()
  {
    return Inertia::render('Items/Create', [
      'restaurants' => RestaurantResource::collection(
        Restaurant::where('user_id', Auth::id())->get()
      ),
      'categories' => CategoryResource::collection(
        Category::all()
      )
    ]);
  }


  public function store(StoreItemRequest $request)
  {
    $fields = $request->validated();

    if ($request->hasFile('image')) {
      $fields['image'] = Storage::disk('public')->put('item_image', $request->image);
    }

    Item::create($fields);
    return to_route('dashboard');
  }

  public function show(Item $item)
  {
    return Inertia::render('Items/Show', [
      'item' => new ItemResource(
        Item::findOrFail($item->id)
      )
    ]);
  }


  public function edit(Item $item)
  {
    return Inertia::render('Items/Edit', [
      'item' => new ItemResource(
        Item::findOrFail($item->id)
      ),
      'restaurants' => RestaurantResource::collection(
        Restaurant::where('user_id', Auth::id())->get()
      ),
      'categories' => CategoryResource::collection(
        Category::all()
      )
    ]);
  }


  public function update(UpdateItemRequest $request, Item $item)
  {
    $getItem = Item::findOrFail($item->id);
    $fields = $request->validated();

    if ($request->hasFile('image') && $request->image !== null) {
      if ($getItem['image'] !== null) {
        Storage::disk('public')->delete($getItem['image']);
      }

      $fields['image'] = Storage::disk('public')->put('item_image', $request->image);
    }

    if ($request->image === null) {
      $fields['image'] = $getItem['image'];
    }

    $item->update($fields);
    return to_route('dashboard');
  }


  public function destroy(Item $item)
  {
    $item->delete();
    return to_route('dashboard');
  }


  public function resetImage(Item $item)
  {
    $getItem = Item::findOrFail($item->id);
    Item::where('id', $item->id)->update(['image' => '']);
    Storage::disk('public')->delete($getItem['image']);
  }
}
