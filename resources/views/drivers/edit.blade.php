@extends('layouts.app')

@section('title', __('Уреди возач'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Уреди возач') }}</h1>

    <form method="POST" action="{{ route('drivers.update', $driver) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Име') }}</label>
            <input type="text" name="first_name" value="{{ old('first_name', $driver->first_name) }}" required
                class="w-full border rounded px-3 py-2 @error('first_name') border-red-500 @enderror">
            @error('first_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Презиме') }}</label>
            <input type="text" name="last_name" value="{{ old('last_name', $driver->last_name) }}" required
                class="w-full border rounded px-3 py-2 @error('last_name') border-red-500 @enderror">
            @error('last_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Број на лиценца') }}</label>
            <input type="text" name="license_number" value="{{ old('license_number', $driver->license_number) }}" required
                class="w-full border rounded px-3 py-2 @error('license_number') border-red-500 @enderror">
            @error('license_number')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Телефон') }}</label>
            <input type="tel" name="phone" value="{{ old('phone', $driver->phone) }}"
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Статус') }}</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" {{ $driver->status === 'active' ? 'selected' : '' }}>{{ __('Активно') }}</option>
                <option value="inactive" {{ $driver->status === 'inactive' ? 'selected' : '' }}>{{ __('Неактивно') }}</option>
            </select>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Зачувај') }}
            </button>
            <a href="{{ route('drivers.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
