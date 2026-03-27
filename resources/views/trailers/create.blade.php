@extends('layouts.app')

@section('title', __('Додај приколка'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Нова приколка') }}</h1>

    <form method="POST" action="{{ route('trailers.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Регистарска табла') }}</label>
            <input type="text" name="plate_number" value="{{ old('plate_number') }}" required
                class="w-full border rounded px-3 py-2 @error('plate_number') border-red-500 @enderror"
                placeholder="МК-1234-АБ">
            @error('plate_number')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Тип') }}</label>
            <input type="text" name="type" value="{{ old('type') }}" required
                class="w-full border rounded px-3 py-2 @error('type') border-red-500 @enderror"
                placeholder="Рефрижерирана, Плато...">
            @error('type')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Капацитет на товар (кг)') }}</label>
            <input type="number" name="payload_capacity" value="{{ old('payload_capacity') }}" min="0"
                class="w-full border rounded px-3 py-2"
                placeholder="нпр. 20000">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Статус') }}</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" selected>{{ __('Активно') }}</option>
                <option value="inactive">{{ __('Неактивно') }}</option>
                <option value="maintenance">{{ __('На сервис') }}</option>
            </select>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Создај') }}
            </button>
            <a href="{{ route('trailers.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
