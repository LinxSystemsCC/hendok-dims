<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostWireDrawAddRowRequest extends FormRequest
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
            'intJobNumber' => 'required',
            'intRodSupplier' => 'required|numeric',
            'strRodCode' => 'required|max:255|string',
            'strCastNumber' => 'required|max:255|string',
            'strSerialNumber' => 'required|max:255|string',
            'strBatchNumber' => 'required|max:255|string',
            'fltRodElongation' =>  'required|numeric',
            'fltRodMpa' => 'required|numeric',
        ];
    }
    public function attributes()
    {
        return [
            'intRodSupplier' => 'Rod Supplier',
            'strRodCode' => 'Rod Supplier Code',
            'strCastNumber' => 'Cast Number',
            'strSerialNumber' => 'Serial Number',
            'strBatchNumber' => 'Batch Number',
            'fltRodElongation' => 'Rod Elongation',
            'fltRodMpa' => 'Rod Mpa'
        ];
    }
}
