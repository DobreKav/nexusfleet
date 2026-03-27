@extends('layouts.app')

@section('title', __('Трошоци'))

@section('content')
<div class="bg-white rounded shadow p-4 md:p-6 w-full">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl md:text-3xl font-bold">{{ __('Трошоци') }}</h1>
        <a href="{{ route('expenses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm md:text-base font-medium w-full sm:w-auto text-center">
            {{ __('+ Додај трошок') }}
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2 text-left">{{ __('Возач') }}</th>
                    <th class="border p-2 text-left">{{ __('Тип') }}</th>
                    <th class="border p-2 text-left">{{ __('Износ') }}</th>
                    <th class="border p-2 text-left">{{ __('Км') }}</th>
                    <th class="border p-2 text-left">{{ __('Датум') }}</th>
                    <th class="border p-2 text-left">{{ __('Опис') }}</th>
                    <th class="border p-2 text-left">{{ __('Акции') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses as $expense)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-2">{{ $expense->driver->first_name }} {{ $expense->driver->last_name }}</td>
                        <td class="border p-2">
                            <span class="px-2 py-1 rounded text-xs bg-purple-100 text-purple-800">
                                {{ $expense->type }}
                            </span>
                        </td>
                        <td class="border p-2 font-semibold">{{ number_format($expense->amount, 2) }} ден</td>
                        <td class="border p-2 text-xs">{{ $expense->odometer_reading ? number_format($expense->odometer_reading) : '-' }}</td>
                        <td class="border p-2 text-xs">{{ $expense->expense_date->format('d.m.Y') }}</td>
                        <td class="border p-2 text-xs">{{ Str::limit($expense->description, 30) ?? '-' }}</td>
                        <td class="border p-2 flex gap-2 text-xs">
                            <a href="{{ route('expenses.show', $expense) }}" class="text-blue-600 hover:text-blue-800">{{ __('Прегледај') }}</a>
                            <a href="{{ route('expenses.edit', $expense) }}" class="text-green-600 hover:text-green-800">{{ __('Уреди') }}</a>
                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}" class="inline" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Избриши') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border p-4 text-center text-gray-500">{{ __('Нема трошоци') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-4">
        @forelse ($expenses as $expense)
            <div class="bg-gray-50 border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-bold text-sm">{{ $expense->driver->first_name }} {{ $expense->driver->last_name }}</p>
                        <p class="text-xs text-gray-600">{{ $expense->expense_date->format('d.m.Y') }}</p>
                    </div>
                    <span class="px-2 py-1 rounded text-xs bg-purple-100 text-purple-800">
                        {{ $expense->type }}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-2 mb-3 text-xs">
                    <div>
                        <p class="text-gray-600">Износ:</p>
                        <p class="font-bold text-blue-600">{{ number_format($expense->amount, 2) }} ден</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Км:</p>
                        <p class="font-bold">{{ $expense->odometer_reading ? number_format($expense->odometer_reading) : '-' }}</p>
                    </div>
                </div>

                @if($expense->description)
                    <p class="text-xs text-gray-600 mb-3">{{ Str::limit($expense->description, 50) }}</p>
                @endif

                <div class="flex gap-2 pt-2 border-t">
                    <a href="{{ route('expenses.show', $expense) }}" class="flex-1 text-center text-blue-600 hover:text-blue-800 text-xs font-medium py-2">
                        {{ __('Прегледај') }}
                    </a>
                    <a href="{{ route('expenses.edit', $expense) }}" class="flex-1 text-center text-green-600 hover:text-green-800 text-xs font-medium py-2">
                        {{ __('Уреди') }}
                    </a>
                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}" class="flex-1" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-red-600 hover:text-red-800 text-xs font-medium py-2">
                            {{ __('Избриши') }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-500">{{ __('Нема трошоци') }}</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4 text-sm">
        {{ $expenses->links() }}
    </div>
</div>
@endsection
