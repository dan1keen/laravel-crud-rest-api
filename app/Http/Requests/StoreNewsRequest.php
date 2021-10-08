<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'name'         => 'required|string|max:100',
            'description'  => 'required|string|max:255',
            'text'         => 'required',
            'image'        => 'required_without:image_url|image|mimes:jpg,jpeg,png',
            'image_url'    => 'required_without:image|string',
            'status'       => 'required|boolean',
            'published_at' => 'required|date',

        ];
    }
}
