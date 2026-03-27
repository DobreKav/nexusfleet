@extends('layouts.app')

@section('title', __('Возачи'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Возачи') }}</h1>
        <a href="{{ route('drivers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('+ Додај возач') }}
        </a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2 text-left">{{ __('Име') }}</th>
                <th class="border p-2 text-left">{{ __('Презиме') }}</th>
                <th class="border p-2 text-left">{{ __('Број на лиценца') }}</th>
                <th class="border p-2 text-left">{{ __('Телефон') }}</th>
                <th class="border p-2 text-left">{{ __('Статус') }}</th>
                <th class="border p-2 text-left">{{ __('Акции') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($drivers as $driver)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2">{{ $driver->first_name }}</td>
                    <td class="border p-2">{{ $driver->last_name }}</td>
                    <td class="border p-2 font-mono text-sm">{{ $driver->license_number }}</td>
                    <td class="border p-2">{{ $driver->phone ?? '-' }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-sm {{ $driver->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ __('messages.' . $driver->status) }}
                        </span>
                    </td>
                    <td class="border p-2 flex gap-2">
                        <a href="{{ route('drivers.show', $driver) }}" class="text-blue-600 hover:text-blue-800">{{ __('Прегледај') }}</a>
                        <a href="{{ route('drivers.edit', $driver) }}" class="text-green-600 hover:text-green-800">{{ __('Уреди') }}</a>
                        <form method="POST" action="{{ route('drivers.destroy', $driver) }}" class="inline" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Избриши') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border p-4 text-center text-gray-500">{{ __('Нема возачи') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $drivers->links() }}
    </div>
</div>
@endsection
