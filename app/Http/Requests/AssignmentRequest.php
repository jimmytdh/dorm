<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
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
        return [
            'bed_id' => 'required',
            'profile_id' => 'required',
            'occupation_type' => 'required',
            'check_in' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'bed_id' => 'Bed',
            'profile_id' => 'Profile',
            'occupation_type' => 'Term',
            'check_in' => 'Check-In Date',
        ];
    }
}
