<?php

namespace App\Http\Requests\API;

use App\Traits\ResponseAPI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UserIdRequest extends FormRequest
{
    use ResponseAPI;
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_id" => "required|min:1|exists:users,id"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        if ($validator->errors()->has('user_id') && strpos($validator->errors()->first('user_id'), 'invalid') !== false) {
            throw new HttpResponseException($this->requestNotFound('User not found!'));
        } else {
            throw new HttpResponseException($this->responseValidation($validator->errors(), 'Failed! Must be include user id'));
        }
    }
}
