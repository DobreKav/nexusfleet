<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Models\Truck;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TruckController extends Controller
{
    public function index(): View
    {
        $trucks = Truck::where('company_id', auth()->user()->company_id)
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('trucks.index', compact('trucks'));
    }

    public function create(): View
    {
        return view('trucks.create');
    }

    public function store(StoreTruckRequest $request): RedirectResponse
    {
        Truck::create([
            'company_id' => auth()->user()->company_id,
            ...$request->validated(),
        ]);

        return redirect()
            ->route('trucks.index')
            ->with('success', __('Камионот беше успешно создаден'));
    }

    public function show(Truck $truck): View
    {
        $this->authorize('view', $truck);
        return view('trucks.show', compact('truck'));
    }

    public function edit(Truck $truck): View
    {
        $this->authorize('update', $truck);
        return view('trucks.edit', compact('truck'));
    }

    public function update(UpdateTruckRequest $request, Truck $truck): RedirectResponse
    {
        $this->authorize('update', $truck);
        
        $truck->update($request->validated());

        return redirect()
            ->route('trucks.index')
            ->with('success', __('Камионот беше успешно ажуриран'));
    }

    public function destroy(Truck $truck): RedirectResponse
    {
        $this->authorize('delete', $truck);
        
        $truck->delete();

        return redirect()
            ->route('trucks.index')
            ->with('success', __('Камионот беше успешно избришан'));
    }
}
