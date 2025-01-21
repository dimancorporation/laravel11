<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'b24_deal_id' => $this->faker->uuid(),
            'b24_contact_id' => $this->faker->uuid(),
            'order_id' => $this->faker->uuid(),
            'success' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['CONFIRMED', 'CANCELED']),
            'payment_id' => $this->faker->uuid(),
            'amount' => $this->faker->numberBetween(1, 1000),
            'card_id' => $this->faker->randomNumber(),
            'email' => $this->faker->email(),
            'name' => $this->faker->name(),
            'phone' => $this->faker->e164PhoneNumber(),
            'source' => $this->faker->randomElement(['WEB', 'MOBILE']),
            'user_agent' => $this->faker->userAgent(),
        ];
    }
}
