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
use App\Services\ItemService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function __construct(
        private ItemService $service
    ) {}


    public function store(StoreItemRequest $request)
    {
        Gate::authorize('create', Item::class);
        $this->service->createItem($request);
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
        $this->service->updateItem($request, $item);
        return to_route('restaurants.show', $item->restaurant_id)
            ->with('status', 'item-updated');
    }


    public function destroy(Item $item)
    {
        Gate::authorize('delete', $item);
        $item->delete();
        return to_route('restaurants.show', $item->restaurant_id)
            ->with('status', 'item-deleted');
    }


    public function trashed()
    {
        return Inertia::render('Item/Trashed', [
            'trashedItems' => ItemResource::collection(
                Item::onlyTrashed()
                    ->whereHas('restaurant', function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->get()
            ),
        ]);
    }


    public function restore(Item $item)
    {
        Gate::authorize('restore', $item);
        $item->restore();
        return to_route('items.trashed')->with('status', 'item-restored');
    }


    public function forceDelete(Item $item)
    {
        Gate::authorize('forceDelete', $item);
        $this->service->forceDeleteItem($item);
        return to_route('items.trashed')->with('status', 'item-deleted');
    }
}
