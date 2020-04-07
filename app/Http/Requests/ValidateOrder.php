<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateOrder extends FormRequest
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
            'description' => 'required|string|max:280',
            'service_type' => 'required|numeric|between:1,8'
        ];
    }

    public function formatted()
    {
        $data = $this->all();
        return [
            'description' => $data['description'],
            'service_type_id' => $data['service_type']
        ];
    }
}
