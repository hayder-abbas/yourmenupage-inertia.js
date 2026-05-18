<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        City::factory()->create([
            'city_name' => 'Al-Anbar',
            'city_image' => 'al-anbar.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Babil',
            'city_image' => 'babil.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Baghdad',
            'city_image' => 'baghdad.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Basra',
            'city_image' => 'basra.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Dhi Qar',
            'city_image' => 'dhi-qar.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Al-Qadisiyyah',
            'city_image' => 'al-qadisiyyah.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Diyala',
            'city_image' => 'diyala.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Duhok',
            'city_image' => 'duhok.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Erbil',
            'city_image' => 'erbil.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Karbala',
            'city_image' => 'karbala.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Kirkuk',
            'city_image' => 'kirkuk.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Maysan',
            'city_image' => 'maysan.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Muthanna',
            'city_image' => 'muthanna.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Najaf',
            'city_image' => 'najaf.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Ninawa',
            'city_image' => 'ninawa.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Salah Al-Din',
            'city_image' => 'salah-al-din.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Sulaymaniyah',
            'city_image' => 'sulaymaniyah.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Halabja ',
            'city_image' => 'halabja.webp'
        ]);
        City::factory()->create([
            'city_name' => 'Wasit',
            'city_image' => 'wasit.webp'
        ]);
    }
}
