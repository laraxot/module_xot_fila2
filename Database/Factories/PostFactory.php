<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//---- models ----

/**
 * Class PostFactory.
 */
class PostFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'title' => $this->faker->sentence,
            'guid' => $this->faker->slug,
            'subtitle' => $this->faker->sentence,
            'txt' => $this->faker->paragraph,
            'lang' => app()->getLocale(),
            //'user_id' => factory('App\User')->create()->id,
        ];
    }
}