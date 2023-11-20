<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['phone'] = 'required|string';
        $rules['password'] = 'required|string';
        $rules['remember_me'] = 'boolean';
        return $rules;
    }
    protected function prepareForValidation()
    {
        if ($this->has('phone')) {
            $code_match = array('-', '"', '!',
                '@', '#', '$', '%', '^', '&', '*',
                '(', ')', '_', '+', '{', '}', '|',
                ':', '"', '<', '>', '?', '[', ']',
                ';', "'", ',', '.', '/', '',
                '~', '`',
                '+',
                '=');
            $this->merge(['phone' => str_replace($code_match, '', $this->phone)]);
        }
    }
}
