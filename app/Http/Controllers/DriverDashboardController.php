<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Tour;
use App\Models\DriverExpense;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DriverDashboardController extends Controller
{
    public function index(): View
    {
        $driver = Driver::where('user_id', auth()->user()->id)->firstOrFail();
        $tours = Tour::where('driver_id', $driver->id)
            ->with(['truck', 'partner'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        $activeTours = Tour::where('driver_id', $driver->id)
            ->where('status', 'in-progress')
            ->count();
        
        $totalKm = Tour::where('driver_id', $driver->id)
            ->sum('total_km');
        
        $totalExpenses = DriverExpense::where('driver_id', $driver->id)
            ->sum('amount');

        return view('driver.dashboard', compact('driver', 'tours', 'activeTours', 'totalKm', 'totalExpenses'));
    }

    public function showTour(Tour $tour): View
    {
        $driver = Driver::where('user_id', auth()->user()->id)->firstOrFail();
        $this->authorize('view', $tour);

        if ($tour->driver_id !== $driver->id) {
            abort(403);
        }

        $expenses = DriverExpense::where('tour_id', $tour->id)
            ->where('driver_id', $driver->id)
            ->get();

        return view('driver.tour-detail', compact('tour', 'driver', 'expenses'));
    }

    public function completeTour(Request $request, Tour $tour): RedirectResponse
    {
        $driver = Driver::where('user_id', auth()->user()->id)->firstOrFail();
        
        if ($tour->driver_id !== $driver->id) {
            abort(403);
        }

        $validated = $request->validate([
            'final_km' => 'required|integer|min:' . $tour->total_km,
            'notes' => 'nullable|string|max:500',
        ]);

        $tour->update([
            'status' => 'completed',
            'total_km' => $validated['final_km'] ?? $tour->total_km,
        ]);

        return redirect()->route('driver.dashboard')
            ->with('success', __('Туратата беше успешно завршена! Фактура создадена.').'✓');
    }
}
