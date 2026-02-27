<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutoresRequest extends FormRequest
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
            'Nome_autor' => ['required', 'min:2', 'max:100', 'unique:autores,Nome_autor'],
            'Foto_autor' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'Nome_autor.min' => 'O nome deve ter pelo menos 2 caracteres',
            'Nome_autor.unique' => 'Esse nome já existe, por favor desenvolva mais ou escolha outro nome',
            'Foto_autor.image' => 'A fotografia é obrigatório'
        ];
    }
}
