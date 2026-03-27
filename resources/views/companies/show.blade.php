@extends('layouts.app')

@section('title', $company->name)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $company->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('companies.edit', $company) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ __('Уреди') }}
            </a>
            <a href="{{ route('companies.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Назад') }}
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <strong>✓ {{ session('success') }}</strong>
        </div>
    @endif

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">{{ __('Е-пошта') }}</label>
                <p class="text-gray-600">{{ $company->email }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Даночен број') }}</label>
                <p class="text-gray-600">{{ $company->tax_number }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Корисничко име') }}</label>
                <p class="text-gray-600 font-mono">{{ $company->username }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Тип лиценца') }}</label>
                <p class="text-gray-600">{{ __('messages.' . $company->license_type) }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Статус') }}</label>
                <p class="text-gray-600">{{ __('messages.' . $company->status) }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Администратор') }}</label>
                <p class="text-gray-600">{{ $company->adminUser?->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded">
            <p class="font-bold text-blue-900 mb-2">{{ __('messages.sign_in_with') }}</p>
            <p><strong>{{ __('messages.username_label') }}</strong> <code class="bg-white px-2 py-1 rounded">{{ $company->username }}</code></p>
            <p class="text-sm text-gray-600 mt-1">{{ __('messages.remember_credentials') }}</p>
        </div>
    </div>
</div>
@endsection
