@extends('layouts.app')

@section('title', $partner->name)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $partner->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('partners.edit', $partner) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ __('Уреди') }}
            </a>
            <a href="{{ route('partners.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Назад') }}
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4 border-b pb-4">
            <div>
                <label class="font-medium">{{ __('Тип') }}</label>
                <p class="text-gray-600">
                    @if($partner->type === 'supplier')
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ __('Добавувач') }}</span>
                    @elseif($partner->type === 'client')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">{{ __('Клиент') }}</span>
                    @else
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">{{ __('И добавувач и клиент') }}</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="font-medium">{{ __('Статус') }}</label>
                <p class="text-gray-600">
                    @if($partner->status === 'active')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">{{ __('Активно') }}</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">{{ __('Неактивно') }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 border-b pb-4">
            <div>
                <label class="font-medium">{{ __('Е-пошта') }}</label>
                <p class="text-gray-600">{{ $partner->email ?? '-' }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Телефон') }}</label>
                <p class="text-gray-600">{{ $partner->phone ?? '-' }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Даночен број') }}</label>
                <p class="text-gray-600">{{ $partner->tax_number ?? '-' }}</p>
            </div>
        </div>

        @if($partner->address)
        <div class="border-t pt-4">
            <label class="font-medium">{{ __('Адреса') }}</label>
            <p class="text-gray-600">{{ $partner->address }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
