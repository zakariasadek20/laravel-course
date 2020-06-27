<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStore extends FormRequest
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
            'nom'=>'required|max:30|min:4',
            'prenom'=>'required|max:20|min:4',
            'email'=>'required',
            'tele'=>'required'
        ];
    }
}
