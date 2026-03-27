@extends('layouts.app')

@section('title', __('Додај фактура'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Нова фактура') }}</h1>

    <form method="POST" action="{{ route('invoices.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Тип') }}</label>
            <select name="type" required class="w-full border rounded px-3 py-2 @error('type') border-red-500 @enderror">
                <option value="">Изберете тип...</option>
                <option value="inbound" {{ old('type') === 'inbound' ? 'selected' : '' }}>{{ __('Влезна') }} (Издаток)</option>
                <option value="outbound" {{ old('type') === 'outbound' ? 'selected' : '' }}>{{ __('Излезна') }} (Приход)</option>
            </select>
            @error('type')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Тура') }} (Опционално)</label>
            <select name="tour_id" class="w-full border rounded px-3 py-2 @error('tour_id') border-red-500 @enderror">
                <option value="">Не требе</option>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ old('tour_id') == $tour->id ? 'selected' : '' }}>
                        Тура #{{ $tour->id }} - {{ $tour->start_location }} → {{ $tour->end_location }}
                    </option>
                @endforeach
            </select>
            @error('tour_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Име на клиент/добавувач') }}</label>
            <input type="text" name="client_or_supplier_name" value="{{ old('client_or_supplier_name') }}" required
                class="w-full border rounded px-3 py-2 @error('client_or_supplier_name') border-red-500 @enderror"
                placeholder="нпр. ABC Компанија">
            @error('client_or_supplier_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Износ') }}</label>
            <input type="number" name="amount" value="{{ old('amount') }}" required step="0.01" min="0"
                class="w-full border rounded px-3 py-2 @error('amount') border-red-500 @enderror">
            @error('amount')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Датум на издавање') }}</label>
            <input type="date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required
                class="w-full border rounded px-3 py-2 @error('issue_date') border-red-500 @enderror">
            @error('issue_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Краен датум за плаќање') }}</label>
            <input type="date" name="due_date" value="{{ old('due_date') }}"
                class="w-full border rounded px-3 py-2 @error('due_date') border-red-500 @enderror">
            @error('due_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Статус') }}</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="pending" selected>{{ __('Во исплата') }}</option>
                <option value="paid">{{ __('Плачено') }}</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Забелешка') }}</label>
            <textarea name="notes" class="w-full border rounded px-3 py-2" rows="3" placeholder="Опционално...">{{ old('notes') }}</textarea>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Создај') }}
            </button>
            <a href="{{ route('invoices.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
