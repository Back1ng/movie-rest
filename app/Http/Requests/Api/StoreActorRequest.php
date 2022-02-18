<?php

namespace App\Http\Requests\Api;

class StoreActorRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'string|required',
            'movies' => 'array',
            'movies.*' => 'numeric|exists:movies,id'
        ];
    }

    public function messages()
    {
        return [
            'movies.*.exists' => "The movie_id :input does not exist."
        ];
    }
}
