<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'genre_id' => function () {
                $count = Genre::all()->count();
                if ($count > 1) {
                    return random_int(1, $count);
                }
                return factory(Genre::class)->create()->id;
            },
            'name' => $this->faker->sentence(3)
        ];
    }
}
