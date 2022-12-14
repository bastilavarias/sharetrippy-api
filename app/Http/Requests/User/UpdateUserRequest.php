<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'bio' => 'required|string',
            'location' => 'required|string',
            'display_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
