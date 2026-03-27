<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverExpenseRequest;
use App\Http\Requests\UpdateDriverExpenseRequest;
use App\Http\Requests\StoreDriverExpenseForTourRequest;
use App\Models\DriverExpense;
use App\Models\Driver;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DriverExpenseController extends Controller
{
    public function index(): View
    {
        $expenses = DriverExpense::whereHas('driver', function ($query) {
            $query->where('company_id', auth()->user()->company_id);
        })
            ->with(['driver', 'tour'])
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('expenses.index', compact('expenses'));
    }

    public function create(): View
    {
        $drivers = Driver::where('company_id', auth()->user()->company_id)->get();
        $tours = Tour::where('company_id', auth()->user()->company_id)->get();
        return view('expenses.create', compact('drivers', 'tours'));
    }

    public function store(StoreDriverExpenseRequest $request): RedirectResponse
    {
        DriverExpense::create($request->validated());
        return redirect()->route('expenses.index')->with('success', __('Трошокот беше успешно создаден'));
    }

    public function show(DriverExpense $expense): View
    {
        $this->authorize('view', $expense);
        $expense->load(['driver', 'tour']);
        return view('expenses.show', compact('expense'));
    }

    public function edit(DriverExpense $expense): View
    {
        $this->authorize('update', $expense);
        $drivers = Driver::where('company_id', auth()->user()->company_id)->get();
        $tours = Tour::where('company_id', auth()->user()->company_id)->get();
        return view('expenses.edit', compact('expense', 'drivers', 'tours'));
    }

    public function update(UpdateDriverExpenseRequest $request, DriverExpense $expense): RedirectResponse
    {
        $this->authorize('update', $expense);
        $expense->update($request->validated());
        return redirect()->route('expenses.index')->with('success', __('Трошокот беше успешно ажуриран'));
    }

    public function storeDriverExpense(StoreDriverExpenseForTourRequest $request, Tour $tour): RedirectResponse
    {
        $driver = Driver::where('user_id', auth()->user()->id)->firstOrFail();
        
        // Check if tour belongs to this driver
        if ($tour->driver_id !== $driver->id) {
            abort(403);
        }

        DriverExpense::create([
            'driver_id' => $driver->id,
            'tour_id' => $tour->id,
            'company_id' => auth()->user()->company_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'odometer_reading' => $request->odometer_reading,
            'description' => $request->description ?? null,
        ]);

        return redirect()->route('driver.tour.show', $tour)
            ->with('success', __('Издатокот беше успешно додаден'));
    }

    public function destroy(DriverExpense $expense): RedirectResponse
    {
        $this->authorize('delete', $expense);
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', __('Трошокот беше успешно избришан'));
    }
}
