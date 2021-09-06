<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCartRequest extends FormRequest
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
            'formdata.name' => 'required',
            'formdata.delivery_method' => 'required',
            'formdata.orderqty' => 'required',
            'formdata.price' => 'required',
            'formdata.signature' => 'required',
            'formdata.product_image' => 'required',
            'formdata.delivery_method' => 'required',
        ];
    }
}
