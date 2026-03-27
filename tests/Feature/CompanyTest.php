<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;

    public function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create(['role' => 'super_admin']);
    }

    public function test_super_admin_can_view_companies_index()
    {
        $response = $this->actingAs($this->superAdmin)->get(route('companies.index'));
        $response->assertStatus(200);
        $response->assertViewIs('companies.index');
    }

    public function test_super_admin_can_create_company()
    {
        $companyData = [
            'name' => 'Test Transport Company',
            'email' => 'info@company.com',
            'tax_number' => 'TAX-123456',
            'username' => 'testcompany',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'license_type' => 'trial',
        ];

        $response = $this->actingAs($this->superAdmin)->post(route('companies.store'), $companyData);

        $this->assertDatabaseHas('companies', [
            'name' => 'Test Transport Company',
            'tax_number' => 'TAX-123456',
        ]);

        $response->assertRedirect();
    }

    public function test_super_admin_can_edit_company()
    {
        $company = Company::factory()->create();

        $response = $this->actingAs($this->superAdmin)->put(
            route('companies.update', $company),
            [
                'name' => 'Updated Company Name',
                'email' => 'newemail@company.com',
                'tax_number' => 'TAX-999999',
            ]
        );

        $company->refresh();
        $this->assertEquals('Updated Company Name', $company->name);
        $this->assertEquals('TAX-999999', $company->tax_number);
    }

    public function test_super_admin_can_delete_company()
    {
        $company = Company::factory()->create();

        $response = $this->actingAs($this->superAdmin)->delete(route('companies.destroy', $company));

        $this->assertSoftDeleted('companies', ['id' => $company->id]);
    }

    public function test_non_admin_cannot_view_companies()
    {
        $regularUser = User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($regularUser)->get(route('companies.index'));
        $response->assertForbidden();
    }
}
