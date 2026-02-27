<?php

namespace App\Exports;

use App\Models\Livro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LivrosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Livro::with(['autores', 'editoras'])
            ->get()
            ->map(function ($livro) {

                $nomesAutores = $livro->autores->pluck('Nome_autor')->implode(', ');

                return [
                    'ID' => $livro->id,
                    'ISBN' => $livro->ISBN,
                    'Nome do Livro' => $livro->Nome_livro,
                    'Nome/s do/s autor/s' => $nomesAutores,
                    'Nome da editora' => $livro->editoras->Nome_editora ?? '',
                    'Preço (€)' => $livro->Preco,
                    'Data de Criação' => $livro->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'ISBN',
            'Nome do Livro',
            'Nome/s do/s autor/s',
            'Nome da editora',
            'Preço (€)',
            'Data de Criação'
        ];
    }
}
