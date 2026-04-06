<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Requisicao>
 */
class RequisicaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => fake()->unique()->numerify('REQ#####'),
            'user_id' => 1,
            'livro_id' => 1,
            'data_requisicao' => now(),
            'data_prevista_entrega' => now()->addDays(7),
            'data_entrega_real' => null,
            'estado' => 'requisitado',
        ];
    }
}
