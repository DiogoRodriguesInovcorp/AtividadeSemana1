<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Sala::create([
            'nome' => 'Geral',
        ]);

        \App\Models\Sala::create([
            'nome' => 'Equipa',
        ]);

        \App\Models\Sala::create([
            'nome' => 'Random',
        ]);
    }
}
