<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = Company::with('adminUser')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('companies.create');
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        // Create admin user for the company
        $adminUser = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);

        // Create company
        $company = Company::create([
            'admin_user_id' => $adminUser->id,
            'name' => $request->name,
            'email' => $request->email,
            'tax_number' => $request->tax_number,
            'username' => $request->username,
            'license_type' => $request->license_type,
            'status' => $request->status ?? 'active',
            'license_expires_at' => $request->license_expires_at,
        ]);

        // Link user to company
        $adminUser->update(['company_id' => $company->id]);

        return redirect()
            ->route('companies.show', $company)
            ->with('success', __('Компанијата беше успешно создадена. Креденцијали: ') . $request->username);
    }

    public function show(Company $company): View
    {
        $company->load('adminUser');
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company): View
    {
        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $data = $request->validated();

        // Handle password separately
        if (!empty($data['password'])) {
            $company->adminUser->update(['password' => bcrypt($data['password'])]);
            unset($data['password']);
        }

        $company->update($data);

        return redirect()
            ->route('companies.show', $company)
            ->with('success', __('Компанијата беше успешно ажурирана'));
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', __('Компанијата беше успешно избришана'));
    }
}
