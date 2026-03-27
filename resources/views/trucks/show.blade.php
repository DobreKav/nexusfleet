@extends('layouts.app')

@section('title', $truck->plate_number)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $truck->plate_number }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('trucks.edit', $truck) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ __('Уреди') }}
            </a>
            <a href="{{ route('trucks.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Назад') }}
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">{{ __('Марка') }}</label>
                <p class="text-gray-600">{{ $truck->brand }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Модел') }}</label>
                <p class="text-gray-600">{{ $truck->model }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Година') }}</label>
                <p class="text-gray-600">{{ $truck->year }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Вкупно км') }}</label>
                <p class="text-gray-600">{{ number_format($truck->total_km) }} км</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Моментална километража') }}</label>
                <p class="text-gray-600 font-bold text-lg">{{ number_format($truck->current_odometer) }} км</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Сервисен интервал') }}</label>
                <p class="text-gray-600">{{ number_format($truck->service_interval_km) }} км</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Статус') }}</label>
                <p class="text-gray-600">{{ __('messages.' . $truck->status) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
