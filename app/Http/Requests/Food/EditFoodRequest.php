<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class EditFoodRequest extends FormRequest
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
            'old_name'  => 'required|string|max:50',
            'new_name'  => 'required|string|max:50|different:old_name'
        ];
    }
}
