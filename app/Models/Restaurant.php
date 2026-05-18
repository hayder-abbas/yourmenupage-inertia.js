<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Restaurant extends Model
{
    use HasFactory;

    protected $with = ['restaurantPhones'];

    protected $fillable = [
        'rest_name',
        'rest_desc',
        'rest_logo',
        'location',
        'open_at',
        'close_at',
        'user_id',
        'city_id'
    ];

    protected $casts = [
        'open_at'  => 'datetime:H:i',
        'close_at' => 'datetime:H:i',
    ];

    public function getIsOpenAttribute(): bool
    {
        $now = Carbon::now()->format('H:i');
        $open  = Carbon::parse($this->open_at)->format('H:i');
        $close = Carbon::parse($this->close_at)->format('H:i');

        // Handle overnight hours (e.g., open 22:00, close 02:00)
        if ($close < $open) {
            return $now >= $open || $now < $close;
        }
        return $now >= $open && $now < $close;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function restaurantPhones(): HasMany
    {
        return $this->hasMany(RestaurantPhone::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
