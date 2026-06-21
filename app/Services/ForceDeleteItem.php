<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ForceDeleteItem
{
    public function forceDelete(Item $item)
    {
        if ($item->item_image) {
            try {
                Storage::disk('public')->delete($item->item_image);
            } catch (\Exception $ex) {
                Log::warning('Failed to delete item image: ' . $ex->getMessage());
            }
        }
        $item->forceDelete();
    }
}
