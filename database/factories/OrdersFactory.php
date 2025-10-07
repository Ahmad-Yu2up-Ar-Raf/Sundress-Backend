<?php

namespace Database\Factories;

use App\Enums\Courier;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Helpers\ImageHelper;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{  
    protected $model = Orders::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Products::factory(),
            'address' => $this->faker->address(),
            'notes' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(OrderStatus::cases()),
            'payment_method' => $this->faker->randomElement(PaymentMethod::cases()),
            'courier' => $this->faker->randomElement(Courier::cases()),
            'total_price' => $this->faker->numberBetween(10000, 5000000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'paid_at' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'),
            'payment_proof' => ImageHelper::random(),
           
        ];
    }
}
