<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StorePostWireDrawProductsRequest extends FormRequest
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
            'strProductName' => 'required|string|max:255',
            'ftlWireSize' => 'required|max:255',
            'strSizeTolerance' => 'required|string|max:255',
            'strMPATolerance' => 'required|string|max:255',
            'intCustomerId' => [
                'required',
                Rule::notIn(['select']),
            ],
        ];
        
    }
    public function attributes()
    {
        return [
            'strProductName' => 'Product Name',
            'ftlWireSize' => 'Wire Size',
            'strSizeTolerance' => 'Size Tolerance',
            'intCustomerId' => 'Customer Name',
            'strMPATolerance' => 'MPA Tolerance'
        ];
    }
}
