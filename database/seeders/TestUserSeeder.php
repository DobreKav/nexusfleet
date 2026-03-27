<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test company
        $company = Company::create([
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'username' => 'testcompany',
            'tax_number' => '1234567890',
            'license_type' => 'trial',
            'status' => 'active',
        ]);

        // Create a super admin user
        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        // Create a company admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'company_id' => $company->id,
        ]);

        // Update company to have this admin as admin_user_id
        $company->update(['admin_user_id' => $admin->id]);
    }
}
