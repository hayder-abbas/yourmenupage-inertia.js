<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function create()
    {
        return Inertia::render('Items/Create', [
            'restaurants' => DB::table('restaurants')
                ->where('user_id', Auth::id())
                ->get(['id', 'name']),

            'categories' => DB::table('categories')
                ->get(['id', 'name']),
        ]);
    }


    public function store(StoreItemRequest $request)
    {
        $fields = $request->validated();

        if ($request->hasFile('image')) {
            $fields['image'] = Storage::disk('public')
                ->put('item_image', $request->image);
        }

        Item::create($fields);

        return to_route('dashboard')->with('status', 'item-created');
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

            'restaurants' => DB::table('restaurants')
                ->where('user_id', Auth::id())
                ->get(['id', 'name']),

            'categories' => DB::table('categories')
                ->get(['id', 'name']),
        ]);
    }


    public function update(UpdateItemRequest $request, Item $item)
    {
        $getItem = Item::findOrFail($item->id);
        $fields = $request->validated();

        if ($request->hasFile('image')) {
            if ($getItem['image'] !== null) {
                Storage::disk('public')->delete($getItem['image']);
            }
            $fields['image'] = Storage::disk('public')
                ->put('item_image', $request->image);
        }

        if ($fields['image'] === null) {
            $fields['image'] = $getItem['image'];
        }

        $item->update($fields);

        return redirect()->back();
    }


    public function destroy(Item $item)
    {
        $item->delete();
        return to_route('dashboard')->with('status', 'item-deleted');
    }
}
