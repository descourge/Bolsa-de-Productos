<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Luis',
            'email' => 'luis@example.com',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Juan',
            'email' => 'juan@example.com',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Maria',
            'email' => 'maria@example.com',
            'password' => 'password',
        ]);
    }
}