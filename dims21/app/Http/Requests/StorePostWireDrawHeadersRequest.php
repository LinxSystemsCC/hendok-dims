<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostWireDrawHeadersRequest extends FormRequest
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
            'intCustomerId'=>'required',
            'intProductId'=>'required',
            'intWireDrawMachineId'=>'required',
            'strType'=>'required|max:255|string',
            'fltMassRequired' => 'required',
            'strReference' => 'required|max:255|string'

        ];
    }
}
