<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true if authorization is not required
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->method() == 'PATCH') {

            // This validation is use in edit form.
            $rules['name'] = 'required|string';
            $rules['quantity'] = 'required|numeric';
            $rules['description'] = 'required|string';
            $rules['img'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';       // Max file size of 2MB, adjust as needed


        } else {
            // This validation is use in cerate form.
            $rules['name'] = 'required|string';
            $rules['quantity'] = 'required|numeric';
            $rules['description'] = 'required|string';
            $rules['img'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';       // Max file size of 2MB, adjust as needed

        }
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'Please enter your name.',
            'quantity.required' => 'Please enter quantity.',
            'quantity.numeric' => 'quantity should be numeric.',
            'description.required' => 'Please enter your description.',
            'img.image' => 'The file must be an image.',
            'img.mimes' => 'The image must be of type: jpeg, png, jpg, gif, svg.',
            'img.max' => 'Image size must not exceed 2MB.',
        ];
    }
}
