<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'name' => $this->faker->text(rand(6, 20)), 
            // Gera uma string de exatamente 9 dígitos numéricos
            'contact' => $this->faker->numerify('#########'), 
            'email_address' => $this->faker->unique()->safeEmail(),
        ];
    }
}
