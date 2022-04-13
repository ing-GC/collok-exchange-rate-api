<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
    }

    public function after()
    {
        $data = (object) [];

        $data->name = $this->name;
        $data->email = $this->email;
        $data->password = Hash::make($this->password);

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response($errors, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
