<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersPost extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:posts|max:255',
            'user_name' => 'required|unique:posts|max:255',
            'email' => 'required|unique:posts|max:255',
            'password' => 'required|unique:posts|max:255',
            'repassowrd' => 'required|unique:posts|max:255',
        ];
    }
}
