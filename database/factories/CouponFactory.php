<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'program_id' => Program::inRandomOrder()->value('id'),
            'code' => Str::random(10),
            'qr_code' => null,
            'used_at' => null,
        ];
    }
}
