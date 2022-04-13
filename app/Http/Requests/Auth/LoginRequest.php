<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        throw_if(!$this->expectsJson(), new HttpResponseException(
            response([
                'errors' => [
                    'message' => ['The request expects a JSON body']
                ]
            ], Response::HTTP_BAD_REQUEST)
        ));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|exists:users',
            'password' => 'required|string|min:8',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response($errors, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
