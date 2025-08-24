<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,stripe',
            'stripe_token' => 'required_if:payment_method,stripe|string',
        ];
    }
}
