<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $userId = $this->route('user');
        return [
            'fname' => 'required|string|max:255',  // First name is required
            'lname' => 'required|string|max:255',  // Last name is required
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId), // Username must be unique, but ignore the current user's username during update
            ],
            'password' => $this->isMethod('post') ? 'required|string|min:6|confirmed' : 'nullable|string|min:6|confirmed',  // Password is required only on create; nullable during update
        ];
    }

    // Add custom attribute names
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
