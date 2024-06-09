<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function PHPSTORM_META\map;

class UpdateUserRequest extends FormRequest
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
            "bio" => "nullable|min:1|max:255",
            "image" => "nullable",
            "email" => "nullable|email|unique:users,email",
            "private" => "nullable|boolean",
            "username" => "nullable|min:4|max:20|unique:users,username",
            "name" => "nullable|min:2|max:30"
        ];
    }
}
