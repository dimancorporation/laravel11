<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\B24UserField>
 */
class B24UserFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_field' => fake()->slug,
            'b24_field' => fake()->slug,
            'uf_crm_code' => fake()->slug
        ];
    }
}
