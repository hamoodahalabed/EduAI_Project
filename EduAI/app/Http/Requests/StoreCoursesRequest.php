<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursesRequest extends FormRequest
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
          
            'title' => ['required','max:220', 'regex:/^[^\/|\\:?*"<>\n]*$/'],
            'years' => 'required',
            'published' => 'required',
            'description' => 'required',
            'teacher_id'=>'required',
            'departments' => 'required|array|min:1', // Ensures departments is an array and has at least one value
        ];
      

    }
}