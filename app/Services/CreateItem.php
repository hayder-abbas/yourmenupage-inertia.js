<?php

namespace App\Services;

use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class CreateItem
{
    public function create(StoreItemRequest $request)
    {
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
    }
}
