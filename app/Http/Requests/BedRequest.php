<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BedRequest extends FormRequest
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
        $id = $this->route('bed');
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('beds', 'code')->ignore($id), // Username must be unique, but ignore the current user's username during update
            ],
            'description' => 'string|max:255',
            'status' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Room Name'
        ];
    }
}
