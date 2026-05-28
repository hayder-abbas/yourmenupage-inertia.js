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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function store(StoreItemRequest $request)
    {
        Gate::authorize('create', Item::class);

        $fields = $request->validated();
        $imgPath = "item_image/" . $request->restaurant_id;
        $newImgPath = null;

        try {
            if ($request->hasFile('item_image')) {
                $newImgPath = $request->file('item_image')
                    ->store($imgPath, 'public');
                $fields['item_image'] = $newImgPath;
            }
            Item::create($fields);
        } catch (\Exception $ex) {
            if ($newImgPath) {
                Storage::disk('public')->delete($newImgPath);
            }
            throw $ex;
        }

        return redirect()->back()->with('status', 'item-created');
    }


    public function edit(Item $item)
    {
        Gate::authorize('update', $item);

        return Inertia::render('Item/Edit', [
            'item' => new ItemResource($item),
            'restaurants' => RestaurantResource::collection(
                Restaurant::where('user_id', Auth::id())
                    ->get(['id', 'rest_name'])
            ),
            'categories' => CategoryResource::collection(
                Cache::remember('categories', 3600, fn() => Category::all('id', 'cat_name'))
            ),
        ]);
    }


    public function update(UpdateItemRequest $request, Item $item)
    {
        Gate::authorize('update', $item);

        $fields = $request->validated();
        $newImg = null;
        $oldImg = $item->item_image; // capture before update
        $imgPath = "item_image/" . $request->restaurant_id;

        try {
            if ($request->hasFile('item_image')) {
                // 1. Store new image (may throw exception)
                $newImg = $request->file('item_image')
                    ->store($imgPath, 'public');
                $fields['item_image'] = $newImg;
            } else {
                // 2. If no new image, remove the key to keep existing one
                unset($fields['item_image']);
            }
            // 3. Update the item (database operation)
            $item->update($fields);

            // 4. Delete old image only after successful update
            if ($newImg && $oldImg) {
                Storage::disk('public')->delete($oldImg);
            }
        } catch (\Exception $ex) {
            // If anything failed after storing the new item, clean it up
            if ($newImg) {
                Storage::disk('public')->delete($newImg);
            }
            throw $ex;
        }

        return to_route('restaurant.show', $item->restaurant_id)
            ->with('status', 'item-updated');
    }


    public function destroy(Item $item)
    {
        Gate::authorize('delete', $item);

        $item->delete();

        return to_route('restaurant.show', $item->restaurant_id)
            ->with('status', 'item-deleted');
    }


    public function forceDelete(Item $item)
    {
        Gate::authorize('forceDelete', $item);

        if ($item->item_image) {
            Storage::disk('public')->delete($item->item_image);
        }

        $item->hardDelete();

        return redirect()->back()->with('status', 'item-deleted');
    }
}
