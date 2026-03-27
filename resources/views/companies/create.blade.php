@extends('layouts.app')

@section('title', __('Додај компанија'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Нова компанија') }}</h1>

    <form method="POST" action="{{ route('companies.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Име на компанијата') }}</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Е-пошта') }}</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror">
            @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Даночен број') }}</label>
            <input type="text" name="tax_number" value="{{ old('tax_number') }}" required
                class="w-full border rounded px-3 py-2 @error('tax_number') border-red-500 @enderror">
            @error('tax_number')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Корисничко име') }}</label>
            <input type="text" name="username" value="{{ old('username') }}" required
                class="w-full border rounded px-3 py-2 @error('username') border-red-500 @enderror">
            @error('username')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Лозинка') }}</label>
            <input type="password" name="password" required
                class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror">
            @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Потврди лозинка') }}</label>
            <input type="password" name="password_confirmation" required
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Тип лиценца') }}</label>
            <select name="license_type" required class="w-full border rounded px-3 py-2">
                <option value="trial">{{ __('Пробна верзија') }}</option>
                <option value="paid">{{ __('Плаќано') }}</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Статус') }}</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" selected>{{ __('Активно') }}</option>
                <option value="inactive">{{ __('Неактивно') }}</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Лиценцата истекува') }}</label>
            <input type="date" name="license_expires_at" value="{{ old('license_expires_at') }}"
                class="w-full border rounded px-3 py-2 @error('license_expires_at') border-red-500 @enderror">
            @error('license_expires_at')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Создај') }}
            </button>
            <a href="{{ route('companies.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
