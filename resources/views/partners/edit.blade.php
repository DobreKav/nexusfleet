@extends('layouts.app')

@section('title', __('Уреди партнер'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Уреди партнер') }}</h1>

    <form method="POST" action="{{ route('partners.update', $partner) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Име') }}</label>
            <input type="text" name="name" value="{{ old('name', $partner->name) }}" required
                class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Е-пошта') }}</label>
            <input type="email" name="email" value="{{ old('email', $partner->email) }}"
                class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror">
            @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Телефон') }}</label>
            <input type="tel" name="phone" value="{{ old('phone', $partner->phone) }}"
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Даночен број') }}</label>
            <input type="text" name="tax_number" value="{{ old('tax_number', $partner->tax_number) }}"
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Адреса') }}</label>
            <textarea name="address" class="w-full border rounded px-3 py-2" rows="2">{{ old('address', $partner->address) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Тип') }}</label>
            <select name="type" required class="w-full border rounded px-3 py-2 @error('type') border-red-500 @enderror">
                <option value="supplier" {{ $partner->type === 'supplier' ? 'selected' : '' }}>{{ __('Добавувач') }}</option>
                <option value="client" {{ $partner->type === 'client' ? 'selected' : '' }}>{{ __('Клиент') }}</option>
                <option value="both" {{ $partner->type === 'both' ? 'selected' : '' }}>{{ __('И добавувач и клиент') }}</option>
            </select>
            @error('type')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Статус') }}</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" {{ $partner->status === 'active' ? 'selected' : '' }}>{{ __('Активно') }}</option>
                <option value="inactive" {{ $partner->status === 'inactive' ? 'selected' : '' }}>{{ __('Неактивно') }}</option>
            </select>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Зачувај') }}
            </button>
            <a href="{{ route('partners.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
