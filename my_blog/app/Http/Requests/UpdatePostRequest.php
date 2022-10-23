<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('update',$this->route('post'));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>"required|min:5|unique:posts,title,".$this->route('post')->id,
            'category'=>'required|integer|exists:categories,id',
            'description'=>'required|min:20',
            'tags'=>'required',
            'tags.*'=>'integer|exists:tags,id'
        ];
    }
}
