<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(6),
            'contenu' => fake()->paragraphs(3, true),
            'categorie_id' => Categorie::inRandomOrder()->first()->id,
            'user_id' => User::factory(),
        ];
    }
}