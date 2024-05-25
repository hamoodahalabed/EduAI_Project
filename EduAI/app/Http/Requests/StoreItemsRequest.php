<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemsRequest extends FormRequest
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
            'title' => ['required'], // Disallow emojis in addition to other characters
            'youtube_url' => ['youtube_url'], // Add the custom validation rule here
            'section_id' => 'required',


        ];
        
        
    }

    
    public function messages()
    {
        return [
            'title.required' => 'The Title field is required.',
            'youtube_url' => 'The YouTube URL must be a valid URL.',
            'section_id.required' => 'The Section field is required.',
            
        ];
    }
    
}