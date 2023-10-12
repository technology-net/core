<?php

namespace IBoot\Core\app\Http\Requests\User;

use IBoot\Core\app\Http\Requests\BaseRequest;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'username' => 'required',
            'email' => 'required|email',
            'name' => 'required'
        ];
    }
}
