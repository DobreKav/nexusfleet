@extends('layouts.app')

@section('title', __('Партнери'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Партнери') }}</h1>
        <a href="{{ route('partners.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('+ Додај партнер') }}
        </a>
    </div>

    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2 text-left">{{ __('Име') }}</th>
                <th class="border p-2 text-left">{{ __('Тип') }}</th>
                <th class="border p-2 text-left">{{ __('Е-пошта') }}</th>
                <th class="border p-2 text-left">{{ __('Телефон') }}</th>
                <th class="border p-2 text-left">{{ __('Статус') }}</th>
                <th class="border p-2 text-left">{{ __('Акции') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($partners as $partner)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2 font-semibold">{{ $partner->name }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
                            {{ __('messages.' . $partner->type) }}
                        </span>
                    </td>
                    <td class="border p-2 text-xs">{{ $partner->email ?? '-' }}</td>
                    <td class="border p-2">{{ $partner->phone ?? '-' }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-xs {{ $partner->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ __('messages.' . $partner->status) }}
                        </span>
                    </td>
                    <td class="border p-2 flex gap-2 text-xs">
                        <a href="{{ route('partners.show', $partner) }}" class="text-blue-600 hover:text-blue-800">{{ __('Прегледај') }}</a>
                        <a href="{{ route('partners.edit', $partner) }}" class="text-green-600 hover:text-green-800">{{ __('Уреди') }}</a>
                        <form method="POST" action="{{ route('partners.destroy', $partner) }}" class="inline" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Избриши') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border p-4 text-center text-gray-500">{{ __('Нема партнери') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $partners->links() }}
    </div>
</div>
@endsection
