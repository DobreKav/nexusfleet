<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Company $company;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->company = Company::factory()->create(['admin_user_id' => $this->user->id]);
        $this->user->update(['company_id' => $this->company->id]);
    }

    public function test_authenticated_user_can_view_invoices_index()
    {
        $response = $this->actingAs($this->user)->get(route('invoices.index'));
        $response->assertStatus(200);
        $response->assertViewIs('invoices.index');
    }

    public function test_authenticated_user_can_create_outbound_invoice()
    {
        $invoiceData = [
            'type' => 'outbound',
            'client_or_supplier_name' => 'Test Client',
            'amount' => 500.00,
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),
        ];

        $response = $this->actingAs($this->user)->post(route('invoices.store'), $invoiceData);

        $this->assertDatabaseHas('invoices', [
            'type' => 'outbound',
            'client_or_supplier_name' => 'Test Client',
            'amount' => 500.00,
        ]);

        $response->assertRedirect();
    }

    public function test_authenticated_user_can_create_inbound_invoice()
    {
        $invoiceData = [
            'type' => 'inbound',
            'client_or_supplier_name' => 'Test Supplier',
            'amount' => 150.00,
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),
        ];

        $response = $this->actingAs($this->user)->post(route('invoices.store'), $invoiceData);

        $this->assertDatabaseHas('invoices', [
            'type' => 'inbound',
            'client_or_supplier_name' => 'Test Supplier',
        ]);

        $response->assertRedirect();
    }

    public function test_authenticated_user_can_edit_invoice()
    {
        $invoice = Invoice::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->put(
            route('invoices.update', $invoice),
            [
                'type' => 'outbound',
                'client_or_supplier_name' => 'Updated Client',
                'amount' => 750.00,
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(30)->toDateString(),
            ]
        );

        $invoice->refresh();
        $this->assertEquals('Updated Client', $invoice->client_or_supplier_name);
        $this->assertEquals(750.00, (float) $invoice->amount);
    }

    public function test_authenticated_user_can_delete_invoice()
    {
        $invoice = Invoice::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->delete(route('invoices.destroy', $invoice));

        $this->assertSoftDeleted('invoices', ['id' => $invoice->id]);
    }

    public function test_invoice_validation_requires_amount()
    {
        $invoiceData = [
            'type' => 'outbound',
            'invoice_number' => 'INV-2024-001',
            'description' => 'Test invoice',
            'date' => now()->toDateString(),
            // Missing amount
        ];

        $response = $this->actingAs($this->user)->post(route('invoices.store'), $invoiceData);

        $response->assertSessionHasErrors('amount');
    }

    public function test_invoice_amount_must_be_positive()
    {
        $invoiceData = [
            'type' => 'outbound',
            'client_or_supplier_name' => 'Test',
            'amount' => -50.00,
            'issue_date' => now()->toDateString(),
            'due_date' => now()->toDateString(),
        ];

        $response = $this->actingAs($this->user)->post(route('invoices.store'), $invoiceData);

        $response->assertSessionHasErrors('amount');
    }
}
