<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     User::factory(5)->seller()->create()->each(function ($user) {
            Products::factory(10)->create(['user_id' => $user->id]);
        });

        // buat 5 buyer
        User::factory(5)->create(); // default role 'buyer'
    }
}
