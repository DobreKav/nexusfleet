@extends('layouts.app')

@section('title', __('Компании'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Компании') }}</h1>
        <a href="{{ route('companies.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('+ Додај компанија') }}
        </a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2 text-left">ID</th>
                <th class="border p-2 text-left">{{ __('Име') }}</th>
                <th class="border p-2 text-left">{{ __('Е-пошта') }}</th>
                <th class="border p-2 text-left">{{ __('Даночен број') }}</th>
                <th class="border p-2 text-left">{{ __('Тип лиценца') }}</th>
                <th class="border p-2 text-left">{{ __('Статус') }}</th>
                <th class="border p-2 text-left">{{ __('Акции') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($companies as $company)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2">{{ $company->id }}</td>
                    <td class="border p-2">{{ $company->name }}</td>
                    <td class="border p-2">{{ $company->email }}</td>
                    <td class="border p-2">{{ $company->tax_number }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-sm {{ $company->license_type === 'trial' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ __('messages.' . $company->license_type) }}
                        </span>
                    </td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-sm {{ $company->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ __('messages.' . $company->status) }}
                        </span>
                    </td>
                    <td class="border p-2 flex gap-2">
                        <a href="{{ route('companies.show', $company) }}" class="text-blue-600 hover:text-blue-800">{{ __('Прегледај') }}</a>
                        <a href="{{ route('companies.edit', $company) }}" class="text-green-600 hover:text-green-800">{{ __('Уреди') }}</a>
                        <form method="POST" action="{{ route('companies.destroy', $company) }}" class="inline" onsubmit="return confirm('{{ __('Сигурни ли сте?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">{{ __('Избриши') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="border p-4 text-center text-gray-500">{{ __('Нема компании') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $companies->links() }}
    </div>
</div>
@endsection
