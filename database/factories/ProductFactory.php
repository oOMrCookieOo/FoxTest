<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
                  $name=fake()->name();
                  return [
                      'image' => 'https://www.lezzat.co.uk/wp-content/uploads/2021/03/Amazon-Product-Photography-Agency-UK-1.jpg',
                      'title' => $name,
                      'slug' => Str::slug($name),
                      'stock'=>rand(10,100),
                      'price'=>rand(100,1000),
                      'category_id'=>Category::query()->inRandomOrder()->first()->id,
                      'description'=>fake()->text,
                      'is_active'=>true
                  ];
    }
}
