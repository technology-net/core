<?php

namespace IBoot\Core\App\Http\Requests;
use Illuminate\Validation\Rule;

class RoleRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('roles')->ignore(request('id')),
            ],
        ];
    }
}
