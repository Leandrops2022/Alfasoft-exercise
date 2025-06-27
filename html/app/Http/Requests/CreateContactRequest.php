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
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be text.',
            'name.min' => 'The name must be at least :min characters.',
            'contact.required' => 'The contact field is required.',
            'contact.string' => 'The contact field must be text.',
            'contact.digits' => 'The contact must be exactly 9 digits.',
            'contact.unique' => 'This contact is already in use.',
            'email_address.required' => 'The email field is required.',
            'email_address.string' => 'The email field must be text.',
            'email_address.email' => 'The email must be a valid email address.',
            'email_address.unique' => 'This email address is already in use.',
        ];
    }
}
