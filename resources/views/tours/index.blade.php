@extends('layouts.app')

@section('title', __('Тури'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Тури') }}</h1>
        <a href="{{ route('tours.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('+ Додај тур') }}
        </a>
    </div>

    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2 text-left">{{ __('Камион') }}</th>
                <th class="border p-2 text-left">{{ __('Возач') }}</th>
                <th class="border p-2 text-left">{{ __('Од → до') }}</th>
                <th class="border p-2 text-left">{{ __('км') }}</th>
                <th class="border p-2 text-left">{{ __('Статус') }}</th>
                <th class="border p-2 text-left">{{ __('Акции') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tours as $tour)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2 font-semibold">{{ $tour->truck->plate_number }}</td>
                    <td class="border p-2">{{ $tour->driver->first_name }} {{ $tour->driver->last_name }}</td>
                    <td class="border p-2 text-xs">{{ $tour->start_location }} → {{ $tour->end_location }}</td>
                    <td class="border p-2">{{ number_format($tour->total_km) }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-xs {{ $tour->status === 'completed' ? 'bg-green-100 text-green-800' : ($tour->status === 'in-progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ __('messages.' . str_replace('-', '_', $tour->status)) }}
                        </span>
                    </td>
                    <td class="border p-2 flex gap-2 text-xs">
                        <a href="{{ route('tours.show', $tour) }}" class="text-blue-600 hover:text-blue-800">{{ __('Прегледај') }}</a>
                        <a href="{{ route('tours.edit', $tour) }}" class="text-green-600 hover:text-green-800">{{ __('Уреди') }}</a>
                        <form method="POST" action="{{ route('tours.destroy', $tour) }}" class="inline" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Избриши') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border p-4 text-center text-gray-500">{{ __('Нема Тури') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $tours->links() }}
    </div>
</div>
@endsection
