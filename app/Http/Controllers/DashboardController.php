<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @todo: Search/Filter Items **/
        // $query = Item::query();
        // $request->validate([
        //     'field' => ['in:id,item_title,item_price,restaurant_id,category_id'],
        //     'direction' => ['in:asc,desc']
        // ]);
        // if ($request->search) {
        //     $query->where('item_title', 'like', "$request->search%");
        // }
        // if ($request->has(['field', 'direction'])) {
        //     $query->orderBy($request->field, $request->direction);
        // }

        return Inertia::render('Dashboard', [
            'restaurants' => RestaurantResource::collection(
                Restaurant::where('user_id', Auth::id())
                    ->select('id', 'rest_name')
                    ->get()
            ),
            // 'filters' => $request->all(['search', 'field', 'direction']),

        ]);
    }
}
