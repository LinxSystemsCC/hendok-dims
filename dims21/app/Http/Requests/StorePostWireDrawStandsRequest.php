<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostWireDrawStandsRequest extends FormRequest
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
            'strStandName' => 'required|unique:tblStands,strStandName',
            'fltStandMass' => 'required|numeric',
            'intDepartmentId' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'strStandName' => 'Stand Name',
            'fltStandMass' => 'Stand Mass',
            'intDepartmentId' => 'Department',
        ];
    }


}
