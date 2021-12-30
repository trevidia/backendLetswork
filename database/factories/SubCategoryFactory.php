<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubCategoryFactory extends Factory
{

    protected $model = SubCategory::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(20),
            'description' => $this->faker->text(),
            'image_url'=> $this->faker->imageUrl(),
            'slug' => $this->faker->slug(),
            'category_id' => mt_rand(1,8)
            //
        ];
    }
}
