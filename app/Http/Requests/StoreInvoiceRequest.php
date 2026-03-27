<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:inbound,outbound',
            'tour_id' => 'nullable|exists:tours,id',
            'client_or_supplier_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
            'status' => 'nullable|in:paid,pending',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => __('Типот на фактура е задолжителен'),
            'client_or_supplier_name.required' => __('Име на клиент/добавувач е задолжително'),
            'amount.required' => __('Износот е задолжителен'),
            'issue_date.required' => __('Датумот на издавање е задолжителен'),
        ];
    }
}
