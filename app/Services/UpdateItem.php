<?php

namespace App\Services;

use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class UpdateItem
{
    public function update(UpdateItemRequest $request, Item $item)
    {
        $fields = $request->validated();
        $oldImg = $item->item_image;
        $imgPath = "item_image/" . $request->restaurant_id;
        $newImg = null;
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
    }
}
