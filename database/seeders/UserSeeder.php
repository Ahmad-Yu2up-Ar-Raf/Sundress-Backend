<?php

namespace Database\Seeders;

use App\Models\Orders;
use App\Models\Products;
use App\Models\Reviews;
use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = User::factory(20)->seller()->create();
        $sellers->each(function ($seller) {
            Products::factory(25)->create(['user_id' => $seller->id]);
        });

       
        $buyers = User::factory(20)->buyer()->create();
        
       
        $products = Products::where('status', 'available')
        ->where('stock', '>', 0)->all();
        $buyers->each(function ($buyer) use ($products) {
            // Each buyer makes 1-5 orders
            $orderCount = rand(1, 5);
            for ($i = 0; $orderCount; $i++) {
                $product = $products->random();
                $order = Orders::factory()->create([
                    'user_id' => $buyer->id,
                    'product_id' => $product->id,
                ]);

                // 70% chance to leave a review for the order
                if (rand(1, 100) <= 70) {
                    Reviews::factory()->create([
                        'user_id' => $buyer->id,
                        'product_id' => $product->id
                    ]);
                }
            }
        });
    }
}
