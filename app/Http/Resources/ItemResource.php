<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'restaurant' => RestaurantResource::make($this->whenLoaded('restaurant')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'id' => $this->id,
            'userID' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'createdAt' => $this->created_at?->toFormattedDateString(),
            'updatedAt' => $this->updated_at?->toFormattedDateString()
        ];
    }
}
