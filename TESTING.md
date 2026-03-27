# Fleet & Logistics Management System - Testing Guide

## Overview
This document provides guidance for testing the Fleet & Logistics Management System application.

## 419 Page Expired Error

The 419 error occurs when either:
1. The CSRF token has expired
2. The session has expired
3. The session is not being maintained properly

### Solutions:
- Clear your browser cache and cookies
- Close and reopen your browser
- Use browser's private/incognito mode
- Reset the application: `php artisan migrate:fresh --seed --seeder=TestUserSeeder`

## Running Tests

### Unit Tests (All Passing ✓)
Run all unit tests:
```bash
php artisan test tests/Unit/
```

Currently includes:
- Tour cost calculation logic validation
- Decimal precision verification
- Cost hierarchy testing (tour > truck > system default)

### Feature Tests (Requires Database Setup)
Before running feature tests, ensure migrations are set up:
```bash
php artisan migrate
```

Run feature tests:
```bash
php artisan test tests/Feature/
```

Feature tests cover:
- Authentication (login/logout)
- CRUD operations for all resources (Tours, Trucks, Drivers, Companies, Invoices)
- Authorization (admin-only features)
- Dashboard financial calculations
- Cost calculation system

## Manual Testing Checklist

### 1. Authentication
- [ ] Navigate to `/login`
- [ ] Login with test credentials: `admin@example.com` / `password`
- [ ] Verify redirect to dashboard
- [ ] Test logout functionality

### 2. Tour Cost Calculation (Key Feature)
- [ ] Go to Trucks page
- [ ] Create a truck with cost_per_km = 0.75 EUR
- [ ] Go to Tours page
- [ ] Create a new tour:
  - [ ] Select the truck created above
  - [ ] Enter total_km = 100
  - [ ] Leave cost_per_km empty (should use truck default of 0.75)
  - [ ] Verify JavaScript shows: 75.00 EUR
  - [ ] Submit and verify total_cost in database = 75.00
- [ ] Edit the same tour:
  - [ ] Change cost_per_km to 0.80
  - [ ] Verify JavaScript recalculates: 80.00 EUR
  - [ ] Submit and verify total_cost = 80.00

### 3. Dashboard Financial Metrics
- [ ] Verify dashboard displays:
  - [ ] Total trucks count
  - [ ] Active tours count
  - [ ] Total km across all tours
  - [ ] **Total tour cost** (sum of all tour total_costs)
  - [ ] **Revenue** (sum of outbound invoices)
  - [ ] **Expenses** (sum of inbound invoices)
  - [ ] **Balance** (revenue - expenses, color-coded)

### 4. CRUD Operations
- [ ] **Trucks**: Create, read, edit, delete with cost_per_km field
- [ ] **Tours**: Create, read, edit, delete with cost calculation
- [ ] **Drivers**: Create, read, edit, delete
- [ ] **Invoices**: Create (both outbound/inbound), read, edit, delete
- [ ] **Partners**: Create, read, edit, delete
- [ ] **Companies**: Super-admin only - create, read, edit, delete

### 5. Multi-Tenant Isolation
- [ ] Create multiple companies (as super-admin)
- [ ] Switch companies in your user session
- [ ] Verify tours/trucks/drivers are scoped to company_id
- [ ] Verify dashboard only shows data for current company

### 6. Form Validation
- [ ] Try creating tour without required fields - should show validation errors
- [ ] Try entering negative cost_per_km - should be rejected
- [ ] Try duplicate license plates for trucks - should be rejected
- [ ] Try duplicate email addresses for drivers - should be rejected

## Database Reset

To reset the application with fresh data:
```bash
php artisan migrate:fresh --seed --seeder=TestUserSeeder
```

This will:
- Drop all tables
- Run all migrations
- Seed test users and some sample data

## Performance Testing

To test with larger datasets:
```bash
php artisan tinker
# Then run:
\App\Models\Tour::factory()->count(1000)->create();
\App\Models\Invoice::factory()->count(500)->create();
```

Then verify dashboard loads quickly and calculations are correct.

## Browser Tests (Manual)

### Test in Different Browsers
- [ ] Chrome/Chromium
- [ ] Firefox
- [ ] Safari
- [ ] Edge

### Responsive Design
- [ ] Desktop (1920x1080)
- [ ] Tablet (768x1024)
- [ ] Mobile (375x667)

## Known Issues & Troubleshooting

### Issue: "Table 'truck.companies' doesn't exist"
**Solution**: Run migrations
```bash
php artisan migrate
```

### Issue: "SQLSTATE[42S22]: Column not found"
**Solution**: Check if all migrations have been run
```bash
php artisan migrate:status
```

### Issue: Cast errors with cost_per_km
**Solution**: Ensure Tour and Truck models have proper decimal casts:
```php
protected $casts = [
    'cost_per_km' => 'decimal:2',
    'total_cost' => 'decimal:2',
];
```

## Test Coverage

Currently Implemented:
- ✓ Unit tests for cost calculation logic
- ✓ Cost per km field on trucks (default 0.50 EUR)
- ✓ Cost per km field on tours (per-tour override)
- ✓ Automatic total_cost calculation
- ✓ Real-time JavaScript preview on forms
- ✓ Dashboard financial aggregation
- ✓ All CRUD operations
- ✓ Multi-tenant scoping
- ✓ Authorization checks

## Configuration Files
- `phpunit.xml` - PHPUnit configuration for tests
- `.env` - Environment variables (check `.env.testing` for test config)
- `routes/web.php` - Application routes
- `routes/auth.php` - Authentication routes

## Next Steps for Testing
1. Run unit tests: `php artisan test tests/Unit/`
2. Perform manual testing using the checklist above
3. Report any issues or bugs in the testing process
4. Complete feature tests once database setup is fully configured

---

**Last Updated**: February 24, 2026
**Application**: Fleet & Logistics Management System v1.0
