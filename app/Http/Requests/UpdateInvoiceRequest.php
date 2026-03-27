<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'type' => 'sometimes|required|in:inbound,outbound',
            'tour_id' => 'nullable|exists:tours,id',
            'client_or_supplier_name' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'issue_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
            'status' => 'nullable|in:paid,pending',
            'notes' => 'nullable|string',
        ];
    }
}
