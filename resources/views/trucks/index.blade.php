@extends('layouts.app')

@section('title', __('Камиони'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Камиони') }}</h1>
        <a href="{{ route('trucks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('+ Додај камион') }}
        </a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2 text-left">ID</th>
                <th class="border p-2 text-left">{{ __('Регистарска табла') }}</th>
                <th class="border p-2 text-left">{{ __('Марка') }}</th>
                <th class="border p-2 text-left">{{ __('Модел') }}</th>
                <th class="border p-2 text-left">{{ __('Година') }}</th>
                <th class="border p-2 text-left">{{ __('Моментална километража') }}</th>
                <th class="border p-2 text-left">{{ __('Статус') }}</th>
                <th class="border p-2 text-left">{{ __('Акции') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trucks as $truck)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2">{{ $truck->id }}</td>
                    <td class="border p-2 font-mono">{{ $truck->plate_number }}</td>
                    <td class="border p-2">{{ $truck->brand }}</td>
                    <td class="border p-2">{{ $truck->model }}</td>
                    <td class="border p-2">{{ $truck->year }}</td>
                    <td class="border p-2 font-semibold">{{ number_format($truck->current_odometer) }} км</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-sm {{ $truck->status === 'active' ? 'bg-green-100 text-green-800' : ($truck->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ __('messages.' . $truck->status) }}
                        </span>
                    </td>
                    <td class="border p-2 flex gap-2">
                        <a href="{{ route('trucks.show', $truck) }}" class="text-blue-600 hover:text-blue-800">{{ __('Прегледај') }}</a>
                        <a href="{{ route('trucks.edit', $truck) }}" class="text-green-600 hover:text-green-800">{{ __('Уреди') }}</a>
                        <form method="POST" action="{{ route('trucks.destroy', $truck) }}" class="inline" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Избриши') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="border p-4 text-center text-gray-500">{{ __('Нема камиони') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $trucks->links() }}
    </div>
</div>
@endsection
