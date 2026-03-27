@extends('layouts.app')

@section('title', __('Додај возач'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Нов возач') }}</h1>

    <form method="POST" action="{{ route('drivers.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Име') }}</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                class="w-full border rounded px-3 py-2 @error('first_name') border-red-500 @enderror">
            @error('first_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Презиме') }}</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required
                class="w-full border rounded px-3 py-2 @error('last_name') border-red-500 @enderror">
            @error('last_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Број на лиценца') }}</label>
            <input type="text" name="license_number" value="{{ old('license_number') }}" required
                class="w-full border rounded px-3 py-2 @error('license_number') border-red-500 @enderror"
                placeholder="нпр. 0123456789012">
            @error('license_number')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Телефон') }}</label>
            <input type="tel" name="phone" value="{{ old('phone') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        <hr class="my-4">

        <div>
            <h3 class="text-lg font-semibold mb-4 text-blue-600">🔑 {{ __('Сметка за логирање') }}</h3>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Е-пошта') }}</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror"
                placeholder="возач@пример.mk">
            @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Корисничко име') }}</label>
            <input type="text" name="username" value="{{ old('username') }}" required
                class="w-full border rounded px-3 py-2 @error('username') border-red-500 @enderror"
                placeholder="vonach1">
            <small class="text-gray-500">Минимум 4 карактери</small>
            @error('username')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Лозинка') }}</label>
            <input type="password" name="password" required
                class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror">
            <small class="text-gray-500">Минимум 6 карактери</small>
            @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Потврди лозинка') }}</label>
            <input type="password" name="password_confirmation" required
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Статус') }}</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" selected>{{ __('Активно') }}</option>
                <option value="inactive">{{ __('Неактивно') }}</option>
            </select>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Создај возач') }}
            </button>
            <a href="{{ route('drivers.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
