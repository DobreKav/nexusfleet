@extends('layouts.app')

@section('title', __('Уреди трошок'))

@section('content')
<div class="bg-white rounded shadow p-4 md:p-6 w-full max-w-2xl">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">{{ __('Уреди трошок') }}</h1>

    <form method="POST" action="{{ route('expenses.update', $expense) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-2">{{ __('Возач') }}</label>
            <select name="driver_id" required
                class="w-full px-3 py-2 text-sm border rounded focus:outline-none focus:border-blue-500 @error('driver_id') border-red-500 @enderror">
                <option value="">Изберете возач...</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ old('driver_id', $expense->driver_id) == $driver->id ? 'selected' : '' }}>
                        {{ $driver->first_name }} {{ $driver->last_name }} ({{ $driver->license_number }})
                    </option>
                @endforeach
            </select>
            @error('driver_id')<span class="text-red-600 text-xs md:text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">{{ __('Тура') }} (Опционално)</label>
            <select name="tour_id"
                class="w-full px-3 py-2 text-sm border rounded focus:outline-none focus:border-blue-500 @error('tour_id') border-red-500 @enderror">
                <option value="">Не требе</option>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ old('tour_id', $expense->tour_id) == $tour->id ? 'selected' : '' }}>
                        Тура #{{ $tour->id }} - {{ $tour->start_location }} → {{ $tour->end_location }}
                    </option>
                @endforeach
            </select>
            @error('tour_id')<span class="text-red-600 text-xs md:text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">{{ __('Тип') }}</label>
            <select name="type" required class="w-full px-3 py-2 text-sm border rounded focus:outline-none focus:border-blue-500 @error('type') border-red-500 @enderror">
                <option value="fuel" {{ $expense->type === 'fuel' ? 'selected' : '' }}>{{ __('Гориво') }}</option>
                <option value="toll" {{ $expense->type === 'toll' ? 'selected' : '' }}>{{ __('Патнина') }}</option>
                <option value="vignette" {{ $expense->type === 'vignette' ? 'selected' : '' }}>{{ __('Винетка') }}</option>
                <option value="maintenance" {{ $expense->type === 'maintenance' ? 'selected' : '' }}>{{ __('Сервис') }}</option>
                <option value="other" {{ $expense->type === 'other' ? 'selected' : '' }}>{{ __('Друго') }}</option>
            </select>
            @error('type')<span class="text-red-600 text-xs md:text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">{{ __('Износ') }}</label>
            <input type="number" name="amount" value="{{ old('amount', $expense->amount) }}" required step="0.01" min="0"
                class="w-full px-3 py-2 text-sm border rounded focus:outline-none focus:border-blue-500 @error('amount') border-red-500 @enderror">
            @error('amount')<span class="text-red-600 text-xs md:text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">{{ __('Датум на трошок') }}</label>
            <input type="date" name="expense_date" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" required
                class="w-full px-3 py-2 text-sm border rounded focus:outline-none focus:border-blue-500 @error('expense_date') border-red-500 @enderror">
            @error('expense_date')<span class="text-red-600 text-xs md:text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">{{ __('Километраж') }} (Опционално)</label>
            <input type="number" name="odometer_reading" value="{{ old('odometer_reading', $expense->odometer_reading) }}" min="0"
                class="w-full px-3 py-2 text-sm border rounded focus:outline-none focus:border-blue-500 @error('odometer_reading') border-red-500 @enderror"
                placeholder="Моментална километража на возилото">
            @error('odometer_reading')<span class="text-red-600 text-xs md:text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">{{ __('Опис') }}</label>
            <textarea name="description" class="w-full px-3 py-2 text-sm border rounded focus:outline-none focus:border-blue-500" rows="3">{{ old('description', $expense->description) }}</textarea>
        </div>

        <div class="flex gap-2 pt-4 flex-col sm:flex-row">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm md:text-base font-medium w-full sm:w-auto">
                {{ __('Зачувај') }}
            </button>
            <a href="{{ route('expenses.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 text-sm md:text-base font-medium text-center sm:text-left w-full sm:w-auto">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
