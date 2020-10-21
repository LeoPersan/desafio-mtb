<?php

namespace App\Http\Requests\Atleta;

use Illuminate\Foundation\Http\FormRequest;

class Senha extends FormRequest
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
            'senha' => 'required|min:6|confirmed',
        ];
    }
}
