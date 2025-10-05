<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products;
use App\Enums\ProductStatus;
use App\Enums\CategoryProductsStatus;
use App\Helpers\ImageHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    protected $model = Products::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
   
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(ProductStatus::class),
            'category' => $this->faker->randomElement(CategoryProductsStatus::class),
           'price' => $this->faker->numberBetween(10000, 5000000),
           'currency' => 'IDR',
'city' => $this->faker->city,
 'country' => $this->faker->country,
            'stock' => $this->faker->numberBetween(1, 100),
   'main_image' => ImageHelper::random(),
        'thumbnail_image' => ImageHelper::random(),
        'showcase_images' => json_encode([
            ImageHelper::random(),
            ImageHelper::random(),
            ImageHelper::random()
        ]),
        ];
    }
}
