<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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

    public function prepareForValidation()
    {
        //just an example of pre validation
        $this->merge(['is_active'=>boolval($this->is_active)]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'title'=>['required','string','max:50'],
            'description'=>['required','string','min:50'],
            'category_id'=>['required','exists:categories,id'],
            'slug'=>['required','string','max:50','unique:products'],
            'stock'=>['required','numeric','min:0'],
            'is_active'=>['required','in:0,1'],
            'price'=>['required','numeric','min:0'],
            'image'=>['required','image','mimes:jpeg,png,jpg,gif']
        ];
    }
}
