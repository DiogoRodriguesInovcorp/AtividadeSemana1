<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditorasRequest extends FormRequest
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
            'Nome_editora' => ['required', 'min:2', 'max:255', 'unique:editoras,Nome_editora'],
            'Logo_editora' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }

    public function messages(): array
    {
        return [
            'Nome_editora.required' => 'O nome é obrigatório',
            'Nome_editora.unique' => 'Esse nome já existe, por favor desenvolva mais ou escolha outro',
            'Nome_editora.min' => 'O nome deve ter pelo menos 2 caracteres',
            'Logo_editora.image' => 'O logotipo é obrigatório',
        ];
    }
}
