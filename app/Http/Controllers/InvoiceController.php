<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::where('company_id', auth()->user()->company_id)
            ->with('tour')
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $tours = Tour::where('company_id', auth()->user()->company_id)->get();
        return view('invoices.create', compact('tours'));
    }

    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        Invoice::create([
            'company_id' => auth()->user()->company_id,
            ...$request->validated(),
        ]);
        return redirect()->route('invoices.index')->with('success', __('Фактурата беше успешно создадена'));
    }

    public function show(Invoice $invoice): View
    {
        $this->authorize('view', $invoice);
        $invoice->load('tour');
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice): View
    {
        $this->authorize('update', $invoice);
        $tours = Tour::where('company_id', auth()->user()->company_id)->get();
        return view('invoices.edit', compact('invoice', 'tours'));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        $this->authorize('update', $invoice);
        $invoice->update($request->validated());
        return redirect()->route('invoices.index')->with('success', __('Фактурата беше успешно ажурирана'));
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $this->authorize('delete', $invoice);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', __('Фактурата беше успешно избришана'));
    }

    public function print(Invoice $invoice): View
    {
        $this->authorize('view', $invoice);
        $invoice->load(['tour', 'company']);
        return view('invoices.print', compact('invoice'));
    }
}
