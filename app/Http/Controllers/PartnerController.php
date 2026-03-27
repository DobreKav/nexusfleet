<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        $partners = Partner::where('company_id', auth()->user()->company_id)
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('partners.index', compact('partners'));
    }

    public function create(): View
    {
        return view('partners.create');
    }

    public function store(StorePartnerRequest $request): RedirectResponse
    {
        Partner::create([
            'company_id' => auth()->user()->company_id,
            ...$request->validated(),
        ]);
        return redirect()->route('partners.index')->with('success', __('Партнерот беше успешно создаден'));
    }

    public function show(Partner $partner): View
    {
        $this->authorize('view', $partner);
        return view('partners.show', compact('partner'));
    }

    public function edit(Partner $partner): View
    {
        $this->authorize('update', $partner);
        return view('partners.edit', compact('partner'));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner): RedirectResponse
    {
        $this->authorize('update', $partner);
        $partner->update($request->validated());
        return redirect()->route('partners.index')->with('success', __('Партнерот беше успешно ажуриран'));
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $this->authorize('delete', $partner);
        $partner->delete();
        return redirect()->route('partners.index')->with('success', __('Партнерот беше успешно избришан'));
    }
}
