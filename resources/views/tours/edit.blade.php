@extends('layouts.app')

@section('title', __('Уреди тура'))

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">{{ __('Уреди тура') }}</h1>

    <form method="POST" action="{{ route('tours.update', $tour) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Камион') }}</label>
            <select name="truck_id" required id="truck-select"
                class="w-full border rounded px-3 py-2 @error('truck_id') border-red-500 @enderror"
                data-trucks="{{ json_encode($trucks->mapWithKeys(function($t) { return [$t->id => ['cost_per_km' => $t->cost_per_km]]; })) }}">
                <option value="">Изберете камион...</option>
                @foreach($trucks as $truck)
                    <option value="{{ $truck->id }}" {{ old('truck_id', $tour->truck_id) == $truck->id ? 'selected' : '' }}>
                        {{ $truck->plate_number }} - {{ $truck->brand }} {{ $truck->model }}
                    </option>
                @endforeach
            </select>
            @error('truck_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Цена по км (ЕУР)') }} <small class="text-gray-500">(Остави празно за камионов default)</small></label>
            <input type="number" name="cost_per_km" value="{{ old('cost_per_km', $tour->cost_per_km) }}" step="0.01" min="0"
                class="w-full border rounded px-3 py-2 @error('cost_per_km') border-red-500 @enderror"
                id="tour-cost-per-km" placeholder="Стандардна цена на камионот">
            <small class="text-gray-500" id="default-cost-display"></small>
            @error('cost_per_km')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Приколка') }}</label>
            <select name="trailer_id"
                class="w-full border rounded px-3 py-2 @error('trailer_id') border-red-500 @enderror">
                <option value="">Опционално...</option>
                @foreach($trailers as $trailer)
                    <option value="{{ $trailer->id }}" {{ old('trailer_id', $tour->trailer_id) == $trailer->id ? 'selected' : '' }}>
                        {{ $trailer->plate_number }} - {{ $trailer->type }}
                    </option>
                @endforeach
            </select>
            @error('trailer_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Возач') }}</label>
            <select name="driver_id" required
                class="w-full border rounded px-3 py-2 @error('driver_id') border-red-500 @enderror">
                <option value="">Изберете возач...</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ old('driver_id', $tour->driver_id) == $driver->id ? 'selected' : '' }}>
                        {{ $driver->first_name }} {{ $driver->last_name }} ({{ $driver->license_number }})
                    </option>
                @endforeach
            </select>
            @error('driver_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Партнер') }}</label>
            <select name="partner_id"
                class="w-full border rounded px-3 py-2 @error('partner_id') border-red-500 @enderror">
                <option value="">Изберете партнер...</option>
                @foreach($partners as $partner)
                    <option value="{{ $partner->id }}" {{ old('partner_id', $tour->partner_id) == $partner->id ? 'selected' : '' }}>
                        {{ $partner->name }}
                    </option>
                @endforeach
            </select>
            @error('partner_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Почетна локација') }}</label>
            <input type="text" name="start_location" value="{{ old('start_location', $tour->start_location) }}" required
                class="w-full border rounded px-3 py-2 @error('start_location') border-red-500 @enderror">
            @error('start_location')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Крајна локација') }}</label>
            <input type="text" name="end_location" value="{{ old('end_location', $tour->end_location) }}" required
                class="w-full border rounded px-3 py-2 @error('end_location') border-red-500 @enderror">
            @error('end_location')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Почетен датум') }}</label>
            <input type="datetime-local" name="start_date" value="{{ old('start_date', $tour->start_date) }}"
                class="w-full border rounded px-3 py-2 @error('start_date') border-red-500 @enderror">
            @error('start_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Краен датум') }}</label>
            <input type="datetime-local" name="end_date" value="{{ old('end_date', $tour->end_date) }}"
                class="w-full border rounded px-3 py-2 @error('end_date') border-red-500 @enderror">
            @error('end_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Вкупно км') }}</label>
            <input type="number" name="total_km" value="{{ old('total_km', $tour->total_km) }}" min="0"
                class="w-full border rounded px-3 py-2" id="tour-km">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Вкупна цена') }}</label>
            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-600 font-bold">
                <span id="tour-cost">{{ number_format($tour->total_cost ?? 0, 2) }}</span> ЕУР
                <small class="text-gray-500 block">({{ $tour->truck->cost_per_km ?? 0.50 }} ЕУР/км)</small>
            </div>
        </div>

        <script>
            const truckSelect = document.getElementById('truck-select');
            const trucksData = JSON.parse(truckSelect.dataset.trucks || '{}');
            const kmInput = document.getElementById('tour-km');
            const costPerKmInput = document.getElementById('tour-cost-per-km');
            const costDisplay = document.getElementById('tour-cost');
            const costPerKmDisplay = document.getElementById('cost-per-km-display');
            const defaultCostDisplay = document.getElementById('default-cost-display');

            function updateCost() {
                const truckId = truckSelect.value;
                const km = parseFloat(kmInput.value) || 0;
                const customCostPerKm = parseFloat(costPerKmInput.value);
                const truckCostPerKm = (trucksData[truckId]?.cost_per_km || 0.50);
                const costPerKm = isNaN(customCostPerKm) ? truckCostPerKm : customCostPerKm;
                const totalCost = (km * costPerKm).toFixed(2);
                costDisplay.textContent = totalCost;
                costPerKmDisplay.textContent = '(' + costPerKm.toFixed(2) + ' ЕУР/км)';
            }

            function updateDefaultDisplay() {
                const truckId = truckSelect.value;
                const truckCostPerKm = (trucksData[truckId]?.cost_per_km || 0.50);
                defaultCostDisplay.textContent = 'Камионов default: ' + truckCostPerKm.toFixed(2) + ' ЕУР/км';
            }

            truckSelect.addEventListener('change', function() {
                updateDefaultDisplay();
                updateCost();
            });
            kmInput.addEventListener('input', updateCost);
            costPerKmInput.addEventListener('input', updateCost);
            updateDefaultDisplay();
            updateCost();
        </script>

        <div>
            <label class="block text-sm font-medium mb-1">{{ __('Статус') }}</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="planned" {{ $tour->status === 'planned' ? 'selected' : '' }}>{{ __('Планирано') }}</option>
                <option value="in-progress" {{ $tour->status === 'in-progress' ? 'selected' : '' }}>{{ __('Во тек') }}</option>
                <option value="completed" {{ $tour->status === 'completed' ? 'selected' : '' }}>{{ __('Завршено') }}</option>
            </select>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Зачувај') }}
            </button>
            <a href="{{ route('tours.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                {{ __('Откажи') }}
            </a>
        </div>
    </form>
</div>
@endsection
