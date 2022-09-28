<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $unique = 'unique:users,email';

        if($this->route()->getName() == 'users.update') {

            $unique = Rule::unique('users', 'email')->ignore($this->id);
        }

        return [
            'email' => ['required', 'email', $unique],
            'first_name' => ['required', 'max:255'],
            'password' => ['required']
        ];
    }
}
