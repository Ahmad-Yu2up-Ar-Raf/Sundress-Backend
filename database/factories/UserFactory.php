<?php

namespace Database\Factories;

use App\Enums\RoleEnums;
use App\Helpers\ImageHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
   protected $model = User::class;
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    
    {
         
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
         'password' => static::$password ??= Hash::make('Pa$$w0rd!'),
            'remember_token' => Str::random(10),
            'avatar' => ImageHelper::random(64, 64),
            'role' => $this->faker->randomElement(RoleEnums::class)
        ];
    }



      public function seller()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'seller',
            ];
        });
    }
      public function buyer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'buyer',
            ];
        });
    }
 
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
