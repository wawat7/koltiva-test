<?php

namespace App\Http\Requests\api\user;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'string|min:3',
            'foto' => 'string|min:10'
        ];
    }
}
