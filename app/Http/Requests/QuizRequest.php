<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'time_limit' => 'nullable|integer|min:1',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*' => 'required|string',
        ];
    }
}
