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
    private static $images=[
      0=>'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/e91d6622-e3e4-4f8b-9cf3-06b91df0fb5b/air-jordan-1-hi-flyease-big-kids-shoes-RHgmLc.png'  ,
      1=>'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/2156e314-9889-4bdc-962d-7350f66cdf7f/air-jordan-1-retro-high-og-mens-shoes-JHpxkn.png'  ,
      2=>'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/207ef489-d26f-47c5-a448-822124014da6/air-jordan-1-high-og-big-kids-shoes-PBgF1q.png'  ,
      3=>'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/5dced730-6399-4801-925d-486345c81c70/air-jordan-1-low-se-womens-shoes-jxMXgH.png'
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
                  $name=fake()->name();
                  return [
                      'image' => self::$images[rand(0,3)],
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
