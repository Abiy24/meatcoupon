<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Program;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        User::factory(100)->create();
        User::factory(100)->valid()->create();
        Program::factory()->create([
            'name' => 'Qurban 2025',
        ]);
        Program::factory()->create([
            'name' => 'Qurban 2026',
        ]);
        Coupon::factory(100)->create();
    }
}
