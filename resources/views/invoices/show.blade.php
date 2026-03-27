@extends('layouts.app')

@section('title', __('Фактура #') . $invoice->id)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Фактура') }} #{{ $invoice->id }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                🖨️ {{ __('Печати') }}
            </a>
            <a href="{{ route('invoices.edit', $invoice) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ __('Уреди') }}
            </a>
            <a href="{{ route('invoices.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Назад') }}
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4 border-b pb-4">
            <div>
                <label class="font-medium">{{ __('Тип') }}</label>
                <p class="text-gray-600">
                    @if($invoice->type === 'inbound')
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">{{ __('Влезна') }}</span>
                    @else
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">{{ __('Излезна') }}</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="font-medium">{{ __('Статус') }}</label>
                <p class="text-gray-600">
                    @if($invoice->status === 'paid')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">{{ __('Плачено') }}</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">{{ __('Во исплата') }}</span>
                    @endif
                </p>
            </div>
            @if($invoice->tour)
            <div>
                <label class="font-medium">{{ __('Тура') }}</label>
                <p class="text-gray-600">#{{ $invoice->tour->id }} - {{ $invoice->tour->start_location }} → {{ $invoice->tour->end_location }}</p>
            </div>
            @endif
            <div>
                <label class="font-medium">{{ __('Износ') }}</label>
                <p class="text-gray-600 font-bold text-lg">{{ number_format($invoice->amount, 2) }} ден</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 border-b pb-4">
            <div>
                <label class="font-medium">{{ __('Име на клиент/добавувач') }}</label>
                <p class="text-gray-600">{{ $invoice->client_or_supplier_name }}</p>
            </div>
            <div></div>
            <div>
                <label class="font-medium">{{ __('Датум на издавање') }}</label>
                <p class="text-gray-600">{{ $invoice->issue_date->format('d.m.Y') }}</p>
            </div>
            <div>
                <label class="font-medium">{{ __('Краен датум') }}</label>
                <p class="text-gray-600">{{ $invoice->due_date?->format('d.m.Y') ?? '-' }}</p>
            </div>
        </div>

        @if($invoice->notes)
        <div class="border-t pt-4">
            <label class="font-medium">{{ __('Забелешка') }}</label>
            <p class="text-gray-600">{{ $invoice->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
