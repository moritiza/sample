<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductUpdateRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'provider_id' => 'filled|exists:providers,id',
            'title' => 'filled|string|max:255',
            'price' => 'filled|numeric',
            'display' => 'filled|in:0,1',
            'comment' => 'filled|in:0,1',
            'vote' => 'filled|in:0,1',
            'buyer_comment_vote' => 'filled|in:0,1',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'provider_id' => 'product provider id',
            'title' => 'product title',
            'price' => 'product price',
            'display' => 'product display or non-display',
            'comment' => 'product ability to submit comments',
            'vote' => 'product ability to submit votes',
            'buyer_comment_vote' => 'product buyers be able to submit comments and votes',
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->toArray();
        $messages = [];

        foreach ($errors as $error) {
            $messages[] = $error[0];
        }

        throw new HttpResponseException(response()->json([
            'message' => $messages
        ], 422, [], JSON_UNESCAPED_UNICODE)
        );
    }
}
