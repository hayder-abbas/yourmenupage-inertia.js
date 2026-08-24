<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

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

    public static function cached()
    {
        return Cache::remember('cities', 3600, fn() => static::all());
    }

    protected static function booted()
    {
        static::saved(fn() => Cache::forget('cities'));
        static::deleted(fn() => Cache::forget('cities'));
    }
}
