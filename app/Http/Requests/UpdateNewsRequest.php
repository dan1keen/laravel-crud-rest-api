<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            'name'         => 'sometimes|string|max:100',
            'description'  => 'sometimes|string|max:255',
            'text'         => 'sometimes',
            'image'        => 'sometimes|image|mimes:jpg,jpeg,png',
            'image_url'    => 'sometimes|string',
            'status'       => 'sometimes|boolean',
        ];
    }
}
