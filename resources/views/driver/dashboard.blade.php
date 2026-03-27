@extends('layouts.app')

@section('title', __('Моја контролна табла'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">{{ __('Добредојде') }}, {{ $driver->first_name }}! 👋</h1>
        <p class="text-gray-600 mt-2">Лиценца: {{ $driver->license_number }}</p>
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-blue-50 p-4 rounded border border-blue-200">
            <h3 class="text-sm font-semibold text-blue-900">{{ __('Активни Тури') }}</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $activeTours }}</p>
        </div>

        <div class="bg-orange-50 p-4 rounded border border-orange-200">
            <h3 class="text-sm font-semibold text-orange-900">{{ __('Вкупно км') }}</h3>
            <p class="text-3xl font-bold text-orange-600">{{ number_format($totalKm) }}</p>
        </div>

        <div class="bg-red-50 p-4 rounded border border-red-200">
            <h3 class="text-sm font-semibold text-red-900">{{ __('Вкупни издатоци') }}</h3>
            <p class="text-3xl font-bold text-red-600">{{ number_format($totalExpenses, 2) }} ден</p>
        </div>
    </div>

    {{-- Tours List --}}
    <div class="border-t pt-6">
        <h2 class="text-2xl font-bold mb-4">{{ __('Мои Тури') }}</h2>
        
        @if($tours->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2 text-left">{{ __('Тура ID') }}</th>
                            <th class="border p-2 text-left">{{ __('Камион') }}</th>
                            <th class="border p-2 text-left">{{ __('Маршрута') }}</th>
                            <th class="border p-2 text-left">{{ __('Км') }}</th>
                            <th class="border p-2 text-left">{{ __('Статус') }}</th>
                            <th class="border p-2 text-left">{{ __('Акција') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tours as $tour)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-2 font-bold">#{{ $tour->id }}</td>
                                <td class="border p-2">{{ $tour->truck->plate_number ?? '-' }}</td>
                                <td class="border p-2 text-xs">
                                    {{ $tour->start_location }} → {{ $tour->end_location }}
                                </td>
                                <td class="border p-2 font-semibold">{{ number_format($tour->total_km) }} км</td>
                                <td class="border p-2">
                                    @if($tour->status === 'in-progress')
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">
                                            🔄 {{ __('Во тек') }}
                                        </span>
                                    @elseif($tour->status === 'completed')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">
                                            ✓ {{ __('Завршена') }}
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">
                                            {{ $tour->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="border p-2">
                                    <a href="{{ route('driver.tour.show', $tour) }}"
                                        class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                        {{ __('Подробности') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border p-4 text-center text-gray-500">
                                    {{ __('Нема доделени Тури') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $tours->links() }}
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded text-center">
                <p class="text-yellow-800">{{ __('Тренутно нема доделени Тури. Слушај на админ панелот!') }} ⏳</p>
            </div>
        @endif
    </div>
</div>
@endsection
