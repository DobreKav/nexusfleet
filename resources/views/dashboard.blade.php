@extends('layouts.app')

@section('title', __('Контролна табла'))

@section('content')
<div class="bg-white rounded shadow p-6">
    <h1 class="text-3xl font-bold mb-6">{{ __('Контролна табла') }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @if (auth()->user()->isSuperAdmin())
            <div class="bg-blue-50 p-6 rounded border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-900">{{ __('Компании') }}</h3>
                <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Company::count() }}</p>
                <a href="{{ route('companies.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                    {{ __('Погледај детали →') }}
                </a>
            </div>
        @endif

        @if (auth()->user()->company_id)
            <div class="bg-green-50 p-6 rounded border border-green-200">
                <h3 class="text-lg font-semibold text-green-900">{{ __('Камиони') }}</h3>
                <p class="text-3xl font-bold text-green-600">
                    {{ \App\Models\Truck::where('company_id', auth()->user()->company_id)->count() }}
                </p>
                <a href="{{ route('trucks.index') }}" class="text-green-500 hover:text-green-700 mt-2 inline-block">
                    {{ __('Погледај детали →') }}
                </a>
            </div>

            <div class="bg-purple-50 p-6 rounded border border-purple-200">
                <h3 class="text-lg font-semibold text-purple-900">{{ __('Активни Тури') }}</h3>
                <p class="text-3xl font-bold text-purple-600">
                    {{ \App\Models\Tour::where('company_id', auth()->user()->company_id)->where('status', 'in-progress')->count() }}
                </p>
                <a href="{{ route('tours.index') }}" class="text-purple-500 hover:text-purple-700 mt-2 inline-block">
                    {{ __('Погледај детали →') }}
                </a>
            </div>

            <div class="bg-orange-50 p-6 rounded border border-orange-200">
                <h3 class="text-lg font-semibold text-orange-900">{{ __('Вкупни км') }}</h3>
                <p class="text-3xl font-bold text-orange-600">
                    {{ number_format(\App\Models\Tour::where('company_id', auth()->user()->company_id)->sum('total_km')) }}
                </p>
            </div>

            <div class="bg-red-50 p-6 rounded border border-red-200">
                <h3 class="text-lg font-semibold text-red-900">{{ __('Вкупна цена на Тури') }}</h3>
                <p class="text-3xl font-bold text-red-600">
                    {{ number_format(\App\Models\Tour::where('company_id', auth()->user()->company_id)->sum('total_cost'), 2) }} ЕУР
                </p>
            </div>

            <div class="bg-indigo-50 p-6 rounded border border-indigo-200">
                <h3 class="text-lg font-semibold text-indigo-900">{{ __('Приход') }}</h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ number_format(\App\Models\Invoice::where('company_id', auth()->user()->company_id)->where('type', 'outbound')->sum('amount'), 2) }} ЕУР
                </p>
            </div>

            <div class="bg-yellow-50 p-6 rounded border border-yellow-200">
                <h3 class="text-lg font-semibold text-yellow-900">{{ __('Издатоци') }}</h3>
                <p class="text-3xl font-bold text-yellow-600">
                    {{ number_format(\App\Models\Invoice::where('company_id', auth()->user()->company_id)->where('type', 'inbound')->sum('amount'), 2) }} ЕУР
                </p>
            </div>

            <div class="bg-teal-50 p-6 rounded border border-teal-200">
                <h3 class="text-lg font-semibold text-teal-900">{{ __('Остаток') }}</h3>
                <?php 
                    $revenue = \App\Models\Invoice::where('company_id', auth()->user()->company_id)->where('type', 'outbound')->sum('amount');
                    $expenses = \App\Models\Invoice::where('company_id', auth()->user()->company_id)->where('type', 'inbound')->sum('amount');
                    $balance = $revenue - $expenses;
                ?>
                <p class="text-3xl font-bold {{ $balance >= 0 ? 'text-teal-600' : 'text-red-600' }}">
                    {{ number_format($balance, 2) }} ЕУР
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

