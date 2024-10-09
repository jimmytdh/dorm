<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
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
        $userId = auth()->id();
        return [
            'fname' => 'required|string|max:255',  // First name is required
            'lname' => 'required|string|max:255',  // Last name is required
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId), // Username must be unique, but ignore the current user's username during update
            ],
            'password' => 'nullable|string|min:6|confirmed',  // Password is required only on create; nullable during update
        ];
    }

    public function attributes()
    {
        return [
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'username' => 'Username',
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
        ];
    }
}
