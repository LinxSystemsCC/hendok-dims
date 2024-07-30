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
            'intjobNumber' => 'required|numeric',
            'intproductId' => 'required|numeric',
            'intstand' => 'required|numeric',
            'intStandId' => 'required|numeric',
            'fltweight' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'intjobNumber' => 'Job No',
            'intproductId' => 'porudect Name',
            'intstand' => 'Stand',
            'intStandId' => 'Stand Name',
        ];
    }
}
