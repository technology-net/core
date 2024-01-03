<?php

namespace IBoot\Core\App\Http\Requests\Auth;

use IBoot\Core\App\Http\Requests\BaseRequest;

class PasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'password' => 'required',
            'new_password' => 'required|same:confirm_password|between:6,20',
        ];
    }
}
