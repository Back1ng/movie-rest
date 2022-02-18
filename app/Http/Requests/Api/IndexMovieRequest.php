<?php

namespace App\Http\Requests\Api;

class IndexMovieRequest extends FormRequest
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
            'genre_id' => 'numeric|nullable|exists:genres,id',
            'actor_id' => 'numeric|nullable|exists:actors,id',
            'sortBy'   => 'string|nullable',
            'sortType' => 'string|nullable',
        ];
    }
}
