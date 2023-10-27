<?php

namespace IBoot\Core\app\Http\Requests;
use Illuminate\Validation\Rule;

class SystemSettingRequest extends BaseRequest
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
            'key' => [
                'required',
                Rule::unique('system_settings')->ignore(request('id')),
            ],
            'value' => 'required',
        ];
    }
}
