<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomAllowedType = $this->randomAllowedType();
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentences('3', true),
            'vote_is_allowed' => $randomAllowedType,
            'comment_is_allowed' => $randomAllowedType,
            'active' => true,
        ];
    }

    private function randomAllowedType()
    {
        return Product::REVIEW_ALLOWED_TYPES[array_rand(Product::REVIEW_ALLOWED_TYPES,'1',)];
    }
}
