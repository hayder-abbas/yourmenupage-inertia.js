<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_name',
        'city_image'
    ];

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }
}
