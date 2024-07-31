<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
    public function rules(): array
    {
        $validations = [
            'strStandName' => ['required'],
            'fltStandMass' => ['required', 'numeric'],
            'intDepartmentId' => ['required'],
        ];

        $uniqueName = Rule::unique('tblStands', 'strStandName');
        if ($this->stand) {
            $uniqueName = $uniqueName->ignore($this->intStandId, 'intStandId');
        }

        $validations['strStandName'][] = $uniqueName;

        return $validations;
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
