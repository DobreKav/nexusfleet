@extends('layouts.app')

@section('title', __('Тура') . ' #' . $tour->id)

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ __('Тура') }} #{{ $tour->id }}</h1>
        <a href="{{ route('driver.dashboard') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
            {{ __('Назад') }}
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <strong>✓ {{ session('success') }}</strong>
        </div>
    @endif

    {{-- Tour Details --}}
    <div class="grid grid-cols-2 gap-4 border-b pb-4 mb-6">
        <div>
            <label class="font-medium">{{ __('Камион') }}</label>
            <p class="text-gray-600">{{ $tour->truck->brand }} {{ $tour->truck->model }} ({{ $tour->truck->plate_number }})</p>
        </div>
        <div>
            <label class="font-medium">{{ __('Партнер') }}</label>
            <p class="text-gray-600">{{ $tour->partner->name ?? '-' }}</p>
        </div>
        <div>
            <label class="font-medium">{{ __('Маршрута') }}</label>
            <p class="text-gray-600">{{ $tour->start_location }} → {{ $tour->end_location }}</p>
        </div>
        <div>
            <label class="font-medium">{{ __('Километража') }}</label>
            <p class="text-gray-600 font-bold">{{ number_format($tour->total_km) }} км</p>
        </div>
        <div>
            <label class="font-medium">{{ __('Цена по км') }}</label>
            <p class="text-gray-600">{{ number_format($tour->cost_per_km, 2) }} ЕУР</p>
        </div>
        <div>
            <label class="font-medium">{{ __('Вкупна цена') }}</label>
            <p class="text-gray-600 font-bold text-lg">{{ number_format($tour->total_cost, 2) }} ЕУР</p>
        </div>
        <div>
            <label class="font-medium">{{ __('Статус') }}</label>
            <p class="text-gray-600">
                @if($tour->status === 'in-progress')
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded font-semibold">🔄 {{ __('Во тек') }}</span>
                @elseif($tour->status === 'completed')
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded font-semibold">✓ {{ __('Завршена') }}</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Expenses Section --}}
    <div class="mb-8 border-b pb-6">
        <h2 class="text-xl font-bold mb-4">{{ __('Дневни издатоци') }}</h2>

        {{-- Add Expense Form --}}
        @if($tour->status === 'in-progress')
        <div class="bg-gray-50 border border-gray-300 p-4 rounded mb-6">
            <h3 class="font-bold mb-3">📝 {{ __('Додај нов издаток') }}</h3>
            <form method="POST" action="{{ route('driver.expense.store', $tour) }}" class="grid grid-cols-2 gap-3">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Тип') }}</label>
                    <select name="type" required class="w-full border rounded px-3 py-2">
                        <option value="">-- {{ __('Избери') }} --</option>
                        <option value="fuel">⛽ {{ __('Гориво') }}</option>
                        <option value="toll">🚧 {{ __('Патнина') }}</option>
                        <option value="vignette">🎫 {{ __('Винетка') }}</option>
                        <option value="maintenance">🔧 {{ __('Сервис') }}</option>
                        <option value="other">📦 {{ __('Друго') }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Износ (ден)') }}</label>
                    <input type="number" name="amount" required step="0.01" min="0" placeholder="0.00"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Км на возилото') }}</label>
                    <input type="number" name="odometer_reading" step="1" min="0" placeholder="опционално"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Датум') }}</label>
                    <input type="date" name="expense_date" required value="{{ date('Y-m-d') }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">{{ __('Напомена') }}</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2" rows="2" placeholder="нпр. Работител, БДП име, итн."></textarea>
                </div>

                <div class="col-span-2">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">
                        ➕ {{ __('Додај издаток') }}
                    </button>
                </div>
            </form>
        </div>
        @endif
        
        @if($expenses->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2 text-left">{{ __('Тип') }}</th>
                            <th class="border p-2 text-left">{{ __('Износ') }}</th>
                            <th class="border p-2 text-left">{{ __('Км') }}</th>
                            <th class="border p-2 text-left">{{ __('Датум') }}</th>
                            <th class="border p-2 text-left">{{ __('Опис') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-2">
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">
                                        {{ __('messages.' . $expense->type) }}
                                    </span>
                                </td>
                                <td class="border p-2 font-semibold">{{ number_format($expense->amount, 2) }} ден</td>
                                <td class="border p-2">{{ $expense->odometer_reading ? number_format($expense->odometer_reading) : '-' }}</td>
                                <td class="border p-2 text-xs">{{ $expense->expense_date->format('d.m.Y') }}</td>
                                <td class="border p-2 text-xs">{{ Str::limit($expense->description, 30) ?? '-' }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-100 font-bold">
                            <td class="border p-2">Вкупно:</td>
                            <td class="border p-2">{{ number_format($expenses->sum('amount'), 2) }} ден</td>
                            <td colspan="3" class="border p-2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 py-4">{{ __('Нема внесени издатоци за оваа Тура') }}</p>
        @endif
    </div>

    {{-- Complete Tour Form --}}
    @if($tour->status === 'in-progress')
        <div class="bg-blue-50 border border-blue-200 p-6 rounded">
            <h3 class="text-lg font-bold mb-4">{{ __('Завршување на Туром') }}</h3>
            <form method="POST" action="{{ route('driver.tour.complete', $tour) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Краен километраж') }}</label>
                    <input type="number" name="final_km" value="{{ old('final_km', $tour->total_km) }}" required min="{{ $tour->total_km }}"
                        class="w-full border rounded px-3 py-2 @error('final_km') border-red-500 @enderror">
                    <small class="text-gray-500">Минимум: {{ number_format($tour->total_km) }} км</small>
                    @error('final_km')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Забелешки (опционално)') }}</label>
                    <textarea name="notes" class="w-full border rounded px-3 py-2" rows="3" placeholder="Додај забелешки за оваа Тура...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 font-bold">
                    {{ __('Завршува Тура') }} ✓
                </button>
            </form>
        </div>
    @elseif($tour->status === 'completed')
        <div class="bg-green-50 border border-green-200 p-6 rounded text-center">
            <h3 class="text-lg font-bold text-green-900 mb-2">✓ {{ __('Оваа Тура е веќе завршена') }}</h3>
            <p class="text-green-800">Фактура беше автоматски креирана.</p>
        </div>
    @endif
</div>
@endsection
