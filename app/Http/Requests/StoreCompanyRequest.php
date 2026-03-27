<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isSuperAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'tax_number' => 'required|string|unique:companies,tax_number',
            'username' => 'required|string|unique:companies,username',
            'password' => 'required|string|min:8|confirmed',
            'license_type' => 'required|in:trial,paid',
            'status' => 'nullable|in:active,inactive',
            'license_expires_at' => 'nullable|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Името на компанијата е задолжително'),
            'email.required' => __('Е-поштата е задолжителна'),
            'email.email' => __('Е-поштата мора да биде валидна'),
            'email.unique' => __('Оваа е-пошта веќе постои'),
            'tax_number.required' => __('Даночниот број е задолжителен'),
            'tax_number.unique' => __('Овој даночен број веќе постои'),
            'username.required' => __('Корисничкото име е задолжително'),
            'username.unique' => __('Ова корисничко име веќе постои'),
            'password.required' => __('Лозинката е задолжителна'),
            'password.min' => __('Лозинката мора да има минимум 8 карактери'),
            'password.confirmed' => __('Лозинките не се совпаѓаат'),
            'license_expires_at.date' => __('Датумот мора да биде валиден'),
            'license_expires_at.after' => __('Датумот на истекување мора да биде во иднина'),
        ];
    }
}
