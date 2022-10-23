<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('create',$this->route('post'));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required|min:5|unique:posts,title',
            'category'=>'required|integer|exists:categories,id',
            'description'=>'required|min:20',
            'photos'=>'required',
            'photos.*'=>'file|max:3000|mimes:jpg,png,jpeg',
            'tags'=>'required',
            'tags.*'=>'integer|exists:tags,id'
        ];
    }
    //custom message
    public function messages()
    {
        return [
            "title.required"=>"ခေါင်းစဉ်ထည့်ဟ ဆရာသမားရ..."
        ];
    }
}
