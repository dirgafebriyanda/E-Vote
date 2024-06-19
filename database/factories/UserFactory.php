<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       return [
        'image' => $this->faker->imageUrl(), // Generate a URL for an image
        'username' => $this->faker->unique()->userName, // Generate a unique username
        'name' => $this->faker->name,
        'jekel' => $this->faker->randomElement(['Perempuan', 'Laki-laki', 'None']), // Generate a random gender
        'tgl_lahir' => $this->faker->date(), // Generate a random date
        'email' => $this->faker->unique()->safeEmail,
        'role' => $this->faker->randomElement(['User']), // Generate a random role
        'email_verified_at' => now(),
        'password' => bcrypt('password'), // Encrypt the password
        'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
