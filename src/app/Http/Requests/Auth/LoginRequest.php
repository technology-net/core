<?php

namespace IBoot\Core\app\Http\Requests\Auth;

use IBoot\Core\app\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'email',
            'password' => 'password'
        ];
    }
}

