<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Luis',
            'email' => 'luis@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Diego',
            'email' => 'diego@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Pablo',
            'email' => 'pablo@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}