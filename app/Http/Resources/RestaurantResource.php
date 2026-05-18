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
            'restName' => $this->rest_name,
            'restDesc' => $this->rest_desc,
            'restLogo' => $this->rest_logo,
            'location' => $this->location,
            'openAt' => $this->open_at?->format('h:i A'),
            'closeAt' => $this->close_at?->format('h:i A'),
            'userId' => $this->user_id,
            'cityId' => $this->city_id,
            'isOpen' => $this->is_open,
            'phones' => RestaurantPhoneResource::collection(
                $this->whenLoaded('restaurantPhones')
            )
        ];
    }
}
