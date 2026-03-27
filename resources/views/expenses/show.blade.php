@extends('layouts.app')

@section('title', __('Трошок #') . $expense->id)

@section('content')
<div class="bg-white rounded shadow p-4 md:p-6 w-full max-w-2xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl md:text-3xl font-bold">{{ __('Трошок') }} #{{ $expense->id }}</h1>
        <div class="flex gap-2 w-full sm:w-auto flex-col sm:flex-row">
            <a href="{{ route('expenses.edit', $expense) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm md:text-base font-medium text-center">
                {{ __('Уреди') }}
            </a>
            <a href="{{ route('expenses.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 text-sm md:text-base font-medium text-center">
                {{ __('Назад') }}
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <!-- Top Grid - Responsive -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-b pb-4">
            <div>
                <label class="font-medium text-sm md:text-base">{{ __('Возач') }}</label>
                <p class="text-gray-600 text-sm md:text-base">{{ $expense->driver->first_name }} {{ $expense->driver->last_name }}</p>
            </div>
            <div>
                <label class="font-medium text-sm md:text-base">{{ __('Тип') }}</label>
                <p class="text-gray-600">
                    @if($expense->type === 'fuel')
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs md:text-sm">{{ __('Гориво') }}</span>
                    @elseif($expense->type === 'toll')
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs md:text-sm">{{ __('Патнина') }}</span>
                    @elseif($expense->type === 'vignette')
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs md:text-sm">{{ __('Винетка') }}</span>
                    @elseif($expense->type === 'maintenance')
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs md:text-sm">{{ __('Сервис') }}</span>
                    @else
                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs md:text-sm">{{ __('Друго') }}</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="font-medium text-sm md:text-base">{{ __('Износ') }}</label>
                <p class="text-gray-600 font-bold text-base md:text-lg">{{ number_format($expense->amount, 2) }} ден</p>
            </div>
            <div>
                <label class="font-medium text-sm md:text-base">{{ __('Датум') }}</label>
                <p class="text-gray-600 text-sm md:text-base">{{ $expense->expense_date->format('d.m.Y') }}</p>
            </div>
            <div>
                <label class="font-medium text-sm md:text-base">{{ __('Километраж') }}</label>
                <p class="text-gray-600 text-sm md:text-base">{{ $expense->odometer_reading ? number_format($expense->odometer_reading) : '-' }} км</p>
            </div>
        </div>

        @if($expense->tour)
        <div class="border-t pt-4">
            <label class="font-medium text-sm md:text-base">{{ __('Тура') }}</label>
            <p class="text-gray-600 text-sm md:text-base">#{{ $expense->tour->id }} - {{ $expense->tour->start_location }} → {{ $expense->tour->end_location }}</p>
        </div>
        @endif

        @if($expense->description)
        <div class="border-t pt-4">
            <label class="font-medium text-sm md:text-base">{{ __('Опис') }}</label>
            <p class="text-gray-600 text-sm md:text-base">{{ $expense->description }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
