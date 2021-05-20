<?php

namespace Database\Factories;

use App\Models\ListMovie;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListMovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ListMovie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->realText(20),
            'description' => $this->faker->realText(200),
            'visibility' => 1
        ];
    }
}
