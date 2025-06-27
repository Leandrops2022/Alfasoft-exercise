<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
        $contactId = (int) $this->route('id');

        return [
            'name' => ['sometimes', 'string', 'min:6'],
            'contact' => [
                'sometimes',
                'string',
                'digits:9',
                Rule::unique('contacts', 'contact')->ignore($contactId),

            ], 
            'email_address' => [
                'sometimes',
                'string', 
                'email', 
                Rule::unique('contacts', 'email_address')->ignore($contactId)
            ],
        ];
    }
}
