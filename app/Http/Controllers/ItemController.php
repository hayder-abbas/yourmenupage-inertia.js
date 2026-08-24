<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Services\CreateItem;
use App\Services\ForceDeleteItem;
use App\Services\UpdateItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ItemController extends Controller
{
    public function store(StoreItemRequest $request, CreateItem $service)
    {
        Gate::authorize('create', Item::class);
        $service->create($request);
        return redirect()->back()->with('status', 'item-created');
    }


    public function edit(Item $item)
    {
        Gate::authorize('update', $item);
        return inertia('Item/Edit', [
            'item' => new ItemResource($item),
            'categories' => CategoryResource::collection(Category::cached()),
        ]);
    }


    public function update(UpdateItemRequest $request, Item $item, UpdateItem $service)
    {
        Gate::authorize('update', $item);
        $service->update($request, $item);
        return redirect(route('restaurants.show', $item->restaurant_id))
            ->with('status', 'item-updated');
    }


    public function destroy(Item $item)
    {
        Gate::authorize('delete', $item);
        $item->delete();
        return redirect()->back()->with('status', 'item-deleted');
    }


    public function trashed()
    {
        return inertia('Item/Trashed', [
            'trashedItems' => ItemResource::collection(
                Item::onlyTrashed()
                    ->whereHas('restaurant', function ($query) {
                        $query->where('user_id', Auth::id());
                    })->get()
            ),
        ]);
    }


    public function restore(Item $item)
    {
        Gate::authorize('restore', $item);
        $item->restore();
        return redirect()->back()->with('status', 'item-restored');
    }


    public function forceDelete(Item $item, ForceDeleteItem $service)
    {
        Gate::authorize('forceDelete', $item);
        $service->forceDelete($item);
        return redirect()->back()->with('status', 'item-deleted');
    }
}
