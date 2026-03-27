<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isSuperAdmin();
    }

    public function rules(): array
    {
        $companyId = $this->route('company')?->id;

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => "sometimes|required|email|unique:companies,email,{$companyId}",
            'tax_number' => "sometimes|required|string|unique:companies,tax_number,{$companyId}",
            'username' => "sometimes|required|string|unique:companies,username,{$companyId}",
            'password' => 'nullable|string|min:8|confirmed',
            'license_type' => 'sometimes|required|in:trial,paid',
            'status' => 'nullable|in:active,inactive',
            'license_expires_at' => 'nullable|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'license_expires_at.date' => __('Датумот мора да биде валиден'),
            'license_expires_at.after' => __('Датумот на истекување мора да биде во иднина'),
        ];
    }
}
