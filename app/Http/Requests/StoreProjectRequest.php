<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //change this from false to true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:projects|bail|min:3|max:200',
            'thumb' => 'nullable|image|max:300',
            'description' => 'nullable|bail|min:3|max:500',
            /* 'tech' => 'nullable|bail|min:3|max:200', */
            'type_id' => ['nullable', 'exists:types,id'],
            'link_github' => 'nullable|bail|url:http,https',
            'link_project_online' => 'nullable|bail|url:http,https',
        ];
    }
}
