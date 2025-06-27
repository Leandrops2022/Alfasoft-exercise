<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:6'],
            'contact' => ['required', 'string', 'digits:9', 'unique:contacts,contact'], 
            'email_address' => ['required', 'string', 'email', 'unique:contacts,email_address'],
        ];
    }

     public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser um texto.',
            'name.min' => 'O nome deve ter no mínimo :min caracteres.',
            'contact.required' => 'O campo contato é obrigatório.',
            'contact.string' => 'O campo contato deve ser um texto.',
            'contact.digits' => 'O contato deve ter exatamente 9 dígitos.',
            'contact.unique' => 'Este contato já está em uso.',
            'email_address.required' => 'O campo email é obrigatório.',
            'email_address.string' => 'O campo email deve ser um texto.',
            'email_address.email' => 'O email deve ser um endereço de email válido.',
            'email_address.unique' => 'Este email já está em uso.',
        ];
    }
}
