<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ISBN' => ['required', 'string', 'max:17', 'unique:livros,ISBN'],
            'Nome_livro' => ['required', 'string', 'max:100'],
            'Editora_id' => ['required', 'string', 'max:100'],
            'autores' => ['required', 'array'],
            'autores.*' => ['exists:autores,id'],
            'Bibliografia' => ['nullable', 'string', 'max:500'],
            'Imagem_da_capa' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'Preco' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'ISBN.required' => 'ISBN é obrigatório',
            'ISBN.unique' => 'ISBN já existe',
            'Nome_livro.required' => 'Nome é obrigatório',
            'Editora_id.required' => 'Nome é obrigatório',
            'Autor_id.required' => 'Nome é obrigatório',
            'Bibliografia.nullable' => 'A bibliografia é opcional',
            'Imagem_da_capa.image' => 'A imagem é obrigatória',
            'Preco.required' => 'O preço é obrigatório'
        ];
    }
}
