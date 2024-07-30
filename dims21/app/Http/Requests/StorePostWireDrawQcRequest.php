<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostWireDrawQcRequest extends FormRequest
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
            'intProductId' => 'required',
            'fltWireSize' => 'required|numeric',
            'intStand' => 'required',
            'strTensileTicketNumber' => 'required',
            'strMPATolerance' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'intJobNumber' => 'Job Number',
            'intProductId' => 'Wire Size',
            'strSizeTolerance' => 'Size Tolerance',
            'intCustomerId' => 'Customer Name',
            'strMPATolerance' => 'MPA Tolerance'
        ];
    }

}
