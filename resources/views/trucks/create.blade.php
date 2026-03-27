@extends('layouts.app')

@section('title', __('Додај камион'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Нов камион') }}</h1>

    <form method="POST" action="{{ route('trucks.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Регистарска табла') }}</label>
            <input type="text" name="plate_number" value="{{ old('plate_number') }}" required
                class="w-full border rounded px-3 py-2 @error('plate_number') border-red-500 @enderror"
                placeholder="МК-1234-АБ">
            @error('plate_number')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Марка') }}</label>
            <input type="text" name="brand" value="{{ old('brand') }}" required
                class="w-full border rounded px-3 py-2 @error('brand') border-red-500 @enderror"
                placeholder="Volvo, Scania, Daf...">
            @error('brand')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Модел') }}</label>
            <input type="text" name="model" value="{{ old('model') }}" required
                class="w-full border rounded px-3 py-2 @error('model') border-red-500 @enderror"
                placeholder="FH16, R480...">
            @error('model')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Година') }}</label>
            <input type="number" name="year" value="{{ old('year') }}" required min="1990" max="{{ date('Y') }}"
                class="w-full border rounded px-3 py-2 @error('year') border-red-500 @enderror">
            @error('year')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Моментална километража') }}</label>
            <input type="number" name="current_odometer" value="{{ old('current_odometer', 0) }}" min="0"
                class="w-full border rounded px-3 py-2 @error('current_odometer') border-red-500 @enderror"
                placeholder="0">
            @error('current_odometer')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Сервисен интервал (км)') }}</label>
            <input type="number" name="service_interval_km" value="{{ old('service_interval_km', 50000) }}" min="1000"
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Цена по км (ЕУР)') }}</label>
            <input type="number" name="cost_per_km" value="{{ old('cost_per_km', 0.50) }}" step="0.01" min="0"
                class="w-full border rounded px-3 py-2"
                placeholder="0.50">
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
            <a href="{{ route('trucks.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
