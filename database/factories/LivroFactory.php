<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ISBN' => fake()->isbn13(),
            'Nome_livro' => fake()->sentence(3),
            'Editora_id' => 1,
            'Bibliografia' => fake()->text(),
            'disponivel' => true,
            'Imagem_da_capa' => 'capa.jpg',
            'Preco' => fake()->randomFloat(2, 5, 50),
        ];
    }
}
