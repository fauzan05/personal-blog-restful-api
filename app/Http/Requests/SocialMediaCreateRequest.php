<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialMediaCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:50'],
            'account_link' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:50'],
            'access_token' => ['nullable', 'string'],
            'additional_information' => ['nullable', 'string']
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response([
            'status' => 'failed',
            'code' => 400,
            'message' => 'Validation Error',
            'api_version' => 'v1',
            'data' => null,
            'error' => [
                'error_message' => $validator->getMessageBag()
            ]       
        ], 400));
    }
}
