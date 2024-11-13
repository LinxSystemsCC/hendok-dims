<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSystemModuleInfoRequest extends FormRequest
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
        $validations = [
            'strName' => ['required'],
        ];
        if ($this->isMethod('put')) {
            $uniqueName = Rule::unique('tblSystemModules', 'strName')
                ->ignore($this->route('system_module'), 'intAutoId');
        } else {
            $uniqueName = Rule::unique('tblSystemModules', 'strName');
        }
        $validations['strName'][] = $uniqueName;

        return $validations;
    }

    public function attributes()
    {
        return [
            'strName' => 'Name',
        ];
    }
}
