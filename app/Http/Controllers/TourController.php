<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Models\Tour;
use App\Models\Truck;
use App\Models\Trailer;
use App\Models\Driver;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TourController extends Controller
{
    public function index(): View
    {
        $tours = Tour::where('company_id', auth()->user()->company_id)
            ->with(['truck', 'driver', 'trailer'])
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('tours.index', compact('tours'));
    }

    public function create(): View
    {
        $trucks = Truck::where('company_id', auth()->user()->company_id)->get();
        $trailers = Trailer::where('company_id', auth()->user()->company_id)->get();
        $drivers = Driver::where('company_id', auth()->user()->company_id)->get();
        $partners = Partner::where('company_id', auth()->user()->company_id)->get();
        return view('tours.create', compact('trucks', 'trailers', 'drivers', 'partners'));
    }

    public function store(StoreTourRequest $request): RedirectResponse
    {
        Tour::create([
            'company_id' => auth()->user()->company_id,
            ...$request->validated(),
        ]);
        return redirect()->route('tours.index')->with('success', __('Туратата беше успешно создадена'));
    }

    public function show(Tour $tour): View
    {
        $this->authorize('view', $tour);
        $tour->load(['truck', 'driver', 'trailer', 'invoices']);
        return view('tours.show', compact('tour'));
    }

    public function edit(Tour $tour): View
    {
        $this->authorize('update', $tour);
        $trucks = Truck::where('company_id', auth()->user()->company_id)->get();
        $trailers = Trailer::where('company_id', auth()->user()->company_id)->get();
        $drivers = Driver::where('company_id', auth()->user()->company_id)->get();
        $partners = Partner::where('company_id', auth()->user()->company_id)->get();
        return view('tours.edit', compact('tour', 'trucks', 'trailers', 'drivers', 'partners'));
    }

    public function update(UpdateTourRequest $request, Tour $tour): RedirectResponse
    {
        $this->authorize('update', $tour);
        $tour->update($request->validated());
        return redirect()->route('tours.index')->with('success', __('Туратата беше успешно ажурирана'));
    }

    public function destroy(Tour $tour): RedirectResponse
    {
        $this->authorize('delete', $tour);
        $tour->delete();
        return redirect()->route('tours.index')->with('success', __('Туратата беше успешно избришана'));
    }
}
