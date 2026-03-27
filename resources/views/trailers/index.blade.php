@extends('layouts.app')

@section('title', __('Приколки'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Приколки') }}</h1>
        <a href="{{ route('trailers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('+ Додај приколка') }}
        </a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2 text-left">{{ __('Табла') }}</th>
                <th class="border p-2 text-left">{{ __('Тип') }}</th>
                <th class="border p-2 text-left">{{ __('Капацитет') }}</th>
                <th class="border p-2 text-left">{{ __('Статус') }}</th>
                <th class="border p-2 text-left">{{ __('Акции') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trailers as $trailer)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2 font-semibold">{{ $trailer->plate_number }}</td>
                    <td class="border p-2">{{ $trailer->type }}</td>
                    <td class="border p-2">{{ number_format($trailer->payload_capacity) }} кг</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-sm {{ $trailer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ __('messages.' . $trailer->status) }}
                        </span>
                    </td>
                    <td class="border p-2 flex gap-2">
                        <a href="{{ route('trailers.show', $trailer) }}" class="text-blue-600 hover:text-blue-800">{{ __('Прегледај') }}</a>
                        <a href="{{ route('trailers.edit', $trailer) }}" class="text-green-600 hover:text-green-800">{{ __('Уреди') }}</a>
                        <form method="POST" action="{{ route('trailers.destroy', $trailer) }}" class="inline" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Избриши') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border p-4 text-center text-gray-500">{{ __('Нема приколки') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $trailers->links() }}
    </div>
</div>
@endsection
