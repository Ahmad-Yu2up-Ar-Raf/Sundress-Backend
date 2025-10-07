<?php

namespace Database\Seeders;

use App\Models\Orders;
use App\Models\Products;
use App\Models\Reviews;
use App\Models\User;
use App\Models\Whishlist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create sellers with their products
        User::factory()
            ->count(20)
            ->seller()
            ->has(
                Products::factory()
                    ->count(5)
                    ->state(function (array $attributes, User $user) {
                        return ['user_id' => $user->id];
                    })
            )
            ->create()
            ->each(function ($seller) {
    
                $products = $seller->products()
                    ->where('status', 'available')
                    ->where('stock', '>', 0)
                    ->get();

                // Only create buyers and orders if there are available products
                if ($products->isNotEmpty()) {
                    User::factory()
                        ->count(3)
                        ->buyer()
                        ->create()
                        ->each(function ($buyer) use ($products) {
                            $orderCount = rand(1, 3);
                            $product = $products->random();


                            for ($i = 0; $i < $orderCount; $i++) {
                                
                                
                                
                                if ($product->stock > 0) {
                                    if (rand(1, 100) <= 90) {
                                        Whishlist::factory()->create([
                                            'user_id' => $buyer->id,
                                            'product_id' => $product->id
                                        ]);
                                    }
                                    $quantity = rand(1, min(3, $product->stock));
                                    
                                    Orders::factory()->create([
                                        'user_id' => $buyer->id,
                                        'product_id' => $product->id,
                                        'quantity' => $quantity,
                                        'total_price' => $product->price * $quantity
                                    ]);

                               

                                    $product->decrement('stock', $quantity);

                                    if (rand(1, 100) <= 70) {
                                        Reviews::factory()->create([
                                            'user_id' => $buyer->id,
                                            'product_id' => $product->id
                                        ]);
                                    }
                                  
                                }
                            }
                        });
                }
            });
    }
}
