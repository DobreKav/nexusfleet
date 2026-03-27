@extends('layouts.app')

@section('title', $trailer->plate_number)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $trailer->plate_number }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('trailers.edit', $trailer) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ __('Уреди') }}
            </a>
            <a href="{{ route('trailers.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Назад') }}
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">{{ __('Тип') }}</label>
                <p class="text-gray-600">{{ $trailer->type }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Капацитет') }}</label>
                <p class="text-gray-600">{{ number_format($trailer->payload_capacity) }} кг</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Статус') }}</label>
                <p class="text-gray-600">
                    @if($trailer->status === 'active')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">{{ __('Активно') }}</span>
                    @elseif($trailer->status === 'maintenance')
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">{{ __('На сервис') }}</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">{{ __('Неактивно') }}</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="font-medium">{{ __('Создадено') }}</label>
                <p class="text-gray-600">{{ $trailer->created_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
