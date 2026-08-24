<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['cat_name'];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public static function cached()
    {
        return Cache::remember('categories', 3600, fn() => static::all());
    }

    protected static function booted()
    {
        static::saved(fn() => Cache::forget('categories'));
        static::deleted(fn() => Cache::forget('categories'));
    }
}
