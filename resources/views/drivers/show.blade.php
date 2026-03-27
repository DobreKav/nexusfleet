@extends('layouts.app')

@section('title', $driver->first_name . ' ' . $driver->last_name)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $driver->first_name }} {{ $driver->last_name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('drivers.edit', $driver) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ __('Уреди') }}
            </a>
            <a href="{{ route('drivers.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Назад') }}
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">{{ __('Број на лиценца') }}</label>
                <p class="text-gray-600">{{ $driver->license_number }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Телефон') }}</label>
                <p class="text-gray-600">{{ $driver->phone ?? '-' }}</p>
            </div>
            @if($driver->user)
            <div>
                <label class="font-medium">{{ __('Корисничко име') }}</label>
                <p class="text-gray-600 font-mono">{{ $driver->user->name }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Е-пошта') }}</label>
                <p class="text-gray-600">{{ $driver->user->email }}</p>
            </div>
            @endif
            <div>
                <label class="font-medium">{{ __('Статус') }}</label>
                <p class="text-gray-600">
                    @if($driver->status === 'active')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">{{ __('Активно') }}</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">{{ __('Неактивно') }}</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="font-medium">{{ __('Создадено') }}</label>
                <p class="text-gray-600">{{ $driver->created_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
