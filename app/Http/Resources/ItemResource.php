<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'itemTitle' => $this->item_title,
            'itemDesc' => $this->item_desc,
            'itemPrice' => $this->item_price,
            'itemImage' => $this->item_image,
            'createdAt' => $this->created_at?->toFormattedDateString(),
            'updatedAt' => $this->updated_at?->toFormattedDateString(),
            'restaurantId' => $this->restaurant_id,
            'categoryId' => $this->category_id
        ];
    }
}
