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
    public function store(StoreItemRequest $request)
    {
        $fields = $request->validated();
        $path = "item_image/" . $request->restaurant_id;

        if ($request->hasFile('item_image')) {
            $fields['item_image'] = Storage::disk('public')
                ->put($path, $request->item_image);
        }
        Item::create($fields);
        return redirect()->back()->with('status', 'item-created');
    }


    public function show(Item $item)
    {
        return Inertia::render('Item/Show', [
            'item' => new ItemResource($item)
        ]);
    }


    public function edit(Item $item)
    {
        return Inertia::render('Item/Edit', [
            'item' => new ItemResource($item),
            'restaurants' => RestaurantResource::collection(
                Restaurant::where('user_id', Auth::id())
                    ->get(['id', 'rest_name'])
            ),
            'categories' => CategoryResource::collection(
                Category::all('id', 'cat_name')
            ),
        ]);
    }


    public function update(UpdateItemRequest $request, Item $item)
    {
        $fields = $request->validated();
        $path = "item_image/" . $request->restaurant_id;

        if ($request->hasFile('item_image')) {
            // Delete old image first
            if ($item->item_image) {
                Storage::disk('public')->delete($item['item_image']);
            }
            $fields['item_image'] = Storage::disk('public')
                ->put($path, $request->item_image);
        } else {
            // Keep existing image if no new one uploaded
            unset($fields['item_image']);
        }

        $item->update($fields);
        return to_route('restaurant.show', $item->restaurant_id)
            ->with('status', 'item-updated');
    }


    public function destroy(Item $item)
    {
        $item->delete();
        return to_route('restaurant.show', $item->restaurant_id)
            ->with('status', 'item-deleted');
    }


    public function hardDelete(Item $item)
    {
        if ($item['item_image']) {
            Storage::disk('public')->delete($item['item_image']);
        }

        $item->hardDelete();
        return to_route('restaurant.show', $item->restaurant_id)
            ->with('status', 'item-deleted');
    }
}
