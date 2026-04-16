<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'openAt' => $this->open_at,
            'closeAt' => $this->close_at,
            // 'city' => CityResource::make($this->whenLoaded('city')),
            // 'createdAt' => $this->created_at?->toFormattedDateString(),
            // 'updatedAt' => $this->updated_at?->toFormattedDateString(),
        ];
    }
}
