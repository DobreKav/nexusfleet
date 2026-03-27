<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DriverController extends Controller
{
    public function index(): View
    {
        $drivers = Driver::where('company_id', auth()->user()->company_id)
            ->with('user')
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('drivers.index', compact('drivers'));
    }

    public function create(): View
    {
        return view('drivers.create');
    }

    public function store(StoreDriverRequest $request): RedirectResponse
    {
        // Create user account for driver
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'driver',
            'company_id' => auth()->user()->company_id,
        ]);

        // Create driver record
        Driver::create([
            'company_id' => auth()->user()->company_id,
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'license_number' => $request->license_number,
            'phone' => $request->phone,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('drivers.index')->with('success', __('Возачот беше успешно создаден. Корисничко име: ' . $request->username));
    }

    public function show(Driver $driver): View
    {
        $this->authorize('view', $driver);
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver): View
    {
        $this->authorize('update', $driver);
        return view('drivers.edit', compact('driver'));
    }

    public function update(UpdateDriverRequest $request, Driver $driver): RedirectResponse
    {
        $this->authorize('update', $driver);
        $driver->update($request->validated());
        return redirect()->route('drivers.index')->with('success', __('Возачот беше успешно ажуриран'));
    }

    public function destroy(Driver $driver): RedirectResponse
    {
        $this->authorize('delete', $driver);
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', __('Возачот беше успешно избришан'));
    }
}
