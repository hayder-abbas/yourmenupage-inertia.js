<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Hayder',
            'last_name' => 'Abbas',
            'email' => 'h@mail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
            'first_name' => 'Abbas',
            'last_name' => 'Ali',
            'email' => 'a@mail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
