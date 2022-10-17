<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(4, true)),
            'thumbnail' => $this->faker->word(),
            'price' => $this->faker->numberBetween(1_000, 100_000),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'updated_at' => Carbon::now(),
        ];
    }
}
