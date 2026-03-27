@extends('layouts.app')

@section('title', __('Уреди приколка'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Уреди приколка') }}</h1>

    <form method="POST" action="{{ route('trailers.update', $trailer) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Регистарска табла') }}</label>
            <input type="text" name="plate_number" value="{{ old('plate_number', $trailer->plate_number) }}" required
                class="w-full border rounded px-3 py-2 @error('plate_number') border-red-500 @enderror">
            @error('plate_number')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Тип') }}</label>
            <input type="text" name="type" value="{{ old('type', $trailer->type) }}" required
                class="w-full border rounded px-3 py-2 @error('type') border-red-500 @enderror">
            @error('type')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Капацитет на товар (кг)') }}</label>
            <input type="number" name="payload_capacity" value="{{ old('payload_capacity', $trailer->payload_capacity) }}" min="0"
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Статус') }}</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" {{ $trailer->status === 'active' ? 'selected' : '' }}>{{ __('Активно') }}</option>
                <option value="inactive" {{ $trailer->status === 'inactive' ? 'selected' : '' }}>{{ __('Неактивно') }}</option>
                <option value="maintenance" {{ $trailer->status === 'maintenance' ? 'selected' : '' }}>{{ __('На сервис') }}</option>
            </select>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Зачувај') }}
            </button>
            <a href="{{ route('trailers.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
