<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'avatar'=>'image|mimes:jpeg,jpg,png,gif,svg|max:1024'
            // 'avatar'=>'image|mimes:jpeg,jpg,png,gif,svg|max:1024|dimensions:height=128,width=128'
        ];
    }
}
