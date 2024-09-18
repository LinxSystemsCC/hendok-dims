<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostWireDrawWeighRequest extends FormRequest
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
            'intJobNumber' => 'required|numeric',
            'intProductId' => 'required|numeric',
            'intStand' => 'required|numeric',
            'intStandId' => 'required|numeric',
            'fltWeight' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'intStandId' => 'Stand Name',
            'fltWeight' => 'weight'
        ];
    }
}
