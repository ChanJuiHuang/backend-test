<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoSearchRequest extends FormRequest
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
            'where_conditions' => 'array',
            'page' => 'bail|required|integer',
            'number_per_page' => 'bail|required|integer',
        ];
    }
}
