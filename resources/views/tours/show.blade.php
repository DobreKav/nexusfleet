@extends('layouts.app')

@section('title', __('Тура') . ' #' . $tour->id)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Тура') }} #{{ $tour->id }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('tours.edit', $tour) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ __('Уреди') }}
            </a>
            <a href="{{ route('tours.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Назад') }}
            </a>
        </div>
    </div>

    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-4 border-b pb-4">
            <div>
                <label class="font-medium">{{ __('Камион') }}</label>
                <p class="text-gray-600">{{ $tour->truck->plate_number }} - {{ $tour->truck->brand }} {{ $tour->truck->model }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Возач') }}</label>
                <p class="text-gray-600">{{ $tour->driver->first_name }} {{ $tour->driver->last_name }}</p>
            </div>
            @if($tour->partner)
            <div>
                <label class="font-medium">{{ __('Партнер') }}</label>
                <p class="text-gray-600">{{ $tour->partner->name }}</p>
            </div>
            @endif
            @if($tour->trailer)
            <div>
                <label class="font-medium">{{ __('Приколка') }}</label>
                <p class="text-gray-600">{{ $tour->trailer->plate_number }} - {{ $tour->trailer->type }}</p>
            </div>
            @endif
            <div>
                <label class="font-medium">{{ __('Статус') }}</label>
                <p class="text-gray-600">
                    @if($tour->status === 'planned')
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">{{ __('Планирано') }}</span>
                    @elseif($tour->status === 'in-progress')
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ __('Во тек') }}</span>
                    @else
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">{{ __('Завршено') }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 border-b pb-4">
            <div>
                <label class="font-medium">{{ __('Почетна локација') }}</label>
                <p class="text-gray-600">{{ $tour->start_location }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Крајна локација') }}</label>
                <p class="text-gray-600">{{ $tour->end_location }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Почетен датум') }}</label>
                <p class="text-gray-600">{{ $tour->start_date ? $tour->start_date->format('d.m.Y H:i') : '-' }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Краен датум') }}</label>
                <p class="text-gray-600">{{ $tour->end_date ? $tour->end_date->format('d.m.Y H:i') : '-' }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Вкупно км') }}</label>
                <p class="text-gray-600">{{ number_format($tour->total_km) }} км</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Вкупна цена') }}</label>
                <p class="text-gray-600 font-bold text-lg">{{ number_format($tour->total_cost ?? 0, 2) }} ЕУР</p>
            </div>
        </div>

        @if($tour->invoices->count() > 0)
        <div class="border-t pt-4">
            <h3 class="text-lg font-bold mb-3">{{ __('Фактури') }}</h3>
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-2 text-left">{{ __('Број') }}</th>
                        <th class="px-2 py-2 text-left">{{ __('Тип') }}</th>
                        <th class="px-2 py-2 text-left">{{ __('Износ') }}</th>
                        <th class="px-2 py-2 text-left">{{ __('Статус') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tour->invoices as $invoice)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-2 py-2">#{{ $invoice->id }}</td>
                        <td class="px-2 py-2">
                            @if($invoice->type === 'inbound')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">{{ __('Влезна') }}</span>
                            @else
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ __('Излезна') }}</span>
                            @endif
                        </td>
                        <td class="px-2 py-2">{{ number_format($invoice->amount, 2) }} ден</td>
                        <td class="px-2 py-2">
                            @if($invoice->status === 'paid')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ __('Плачено') }}</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">{{ __('Во исплата') }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
