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
            'restPhone' => $this->rest_phone,
            'restDesc' => $this->rest_desc,
            'restLogo' => $this->rest_logo,
            'location' => $this->location,
            'openAt' => $this->open_at,
            'closeAt' => $this->close_at,
            'userId' => $this->user_id,
            'cityId' => $this->city_id,
            'isOpen' => $this->is_open,
        ];
    }
}
