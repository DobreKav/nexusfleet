<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrailerRequest;
use App\Http\Requests\UpdateTrailerRequest;
use App\Models\Trailer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrailerController extends Controller
{
    public function index(): View
    {
        $trailers = Trailer::where('company_id', auth()->user()->company_id)
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('trailers.index', compact('trailers'));
    }

    public function create(): View
    {
        return view('trailers.create');
    }

    public function store(StoreTrailerRequest $request): RedirectResponse
    {
        Trailer::create([
            'company_id' => auth()->user()->company_id,
            ...$request->validated(),
        ]);
        return redirect()->route('trailers.index')->with('success', __('Приколката беше успешно создадена'));
    }

    public function show(Trailer $trailer): View
    {
        $this->authorize('view', $trailer);
        return view('trailers.show', compact('trailer'));
    }

    public function edit(Trailer $trailer): View
    {
        $this->authorize('update', $trailer);
        return view('trailers.edit', compact('trailer'));
    }

    public function update(UpdateTrailerRequest $request, Trailer $trailer): RedirectResponse
    {
        $this->authorize('update', $trailer);
        $trailer->update($request->validated());
        return redirect()->route('trailers.index')->with('success', __('Приколката беше успешно ажурирана'));
    }

    public function destroy(Trailer $trailer): RedirectResponse
    {
        $this->authorize('delete', $trailer);
        $trailer->delete();
        return redirect()->route('trailers.index')->with('success', __('Приколката беше успешно избришана'));
    }
}
