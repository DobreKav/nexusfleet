<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:drivers,license_number',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,name|min:4',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'nullable|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('Името е задолжително'),
            'last_name.required' => __('Презимето е задолжително'),
            'license_number.required' => __('Број на лиценца е задолжителен'),
            'license_number.unique' => __('Овој број на лиценца веќе постои'),
            'email.required' => __('Е-поштата е задолжителна'),
            'email.unique' => __('Оваа е-пошта веќе постои'),
            'username.required' => __('Корисничкото име е задолжително'),
            'username.unique' => __('Ова корисничко име веќе постои'),
            'username.min' => __('Корисничкото име мора да има минимум 4 симболи'),
            'password.required' => __('Лозинката е задолжителна'),
            'password.min' => __('Лозинката мора да има минимум 6 карактери'),
            'password.confirmed' => __('Лозинките не се совпаѓаат'),
        ];
    }
}
