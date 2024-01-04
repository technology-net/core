<?php

namespace IBoot\Core\App\Http\Requests\User;

use IBoot\Core\App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'username' => 'required',
            'email' => 'required|email',
            'name' => 'required'
        ];

        if (!empty(request('password'))) {
            $rules['password'] = 'same:confirm_password|between:6,20|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,20}$/';
        }

        return $rules;
    }
}
