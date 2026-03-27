@extends('layouts.app')

@section('title', __('Фактури'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Фактури') }}</h1>
        <a href="{{ route('invoices.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('+ Додај фактура') }}
        </a>
    </div>

    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2 text-left">{{ __('Тип') }}</th>
                <th class="border p-2 text-left">{{ __('Клиент/Добавувач') }}</th>
                <th class="border p-2 text-left">{{ __('Износ') }}</th>
                <th class="border p-2 text-left">{{ __('Датум') }}</th>
                <th class="border p-2 text-left">{{ __('Статус') }}</th>
                <th class="border p-2 text-left">{{ __('Акции') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-xs {{ $invoice->type === 'inbound' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ __('messages.' . $invoice->type) }}
                        </span>
                    </td>
                    <td class="border p-2">{{ $invoice->client_or_supplier_name }}</td>
                    <td class="border p-2 font-semibold">{{ number_format($invoice->amount, 2) }} ден</td>
                    <td class="border p-2 text-xs">{{ $invoice->issue_date->format('d.m.Y') }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-xs {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ __('messages.' . $invoice->status) }}
                        </span>
                    </td>
                    <td class="border p-2 flex gap-2 text-xs">
                        <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-800">{{ __('Прегледај') }}</a>
                        <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="text-purple-600 hover:text-purple-800">{{ __('Печати') }}</a>
                        <a href="{{ route('invoices.edit', $invoice) }}" class="text-green-600 hover:text-green-800">{{ __('Уреди') }}</a>
                        <form method="POST" action="{{ route('invoices.destroy', $invoice) }}" class="inline" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Избриши') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border p-4 text-center text-gray-500">{{ __('Нема фактури') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
