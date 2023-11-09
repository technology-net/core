<?php

namespace IBoot\Core\App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
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
     * @return Validator
     */
    public function getValidator(): Validator
    {
        return $this->validator;
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            responseUnprocessableEntity(
                $validator->errors()->toArray(),
                trans('messages.validation_error')
            )
        );
    }
}
