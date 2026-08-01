<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@staffportal.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Sample Staff Users
        $staff1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@staffportal.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'is_active' => true,
        ]);

        $staff2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@staffportal.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'is_active' => true,
        ]);

        // Create Staff Profiles
        $staff1->staffProfile()->create([
            'employee_id' => 'EMP0001',
            'phone' => '+92 300 1234567',
            'address' => '123 Main Street, Lahore',
            'designation' => 'Senior Developer',
            'joining_date' => now()->subYears(2),
            'employment_status' => 'active',
        ]);

        $staff2->staffProfile()->create([
            'employee_id' => 'EMP0002',
            'phone' => '+92 301 7654321',
            'address' => '456 Park Avenue, Karachi',
            'designation' => 'UI/UX Designer',
            'joining_date' => now()->subYear(),
            'employment_status' => 'active',
        ]);

        // Create Sample Salaries
        $staff1->salaries()->create([
            'amount' => 75000,
            'effective_date' => now()->subYears(2),
            'is_current' => true,
        ]);

        $staff2->salaries()->create([
            'amount' => 60000,
            'effective_date' => now()->subYear(),
            'is_current' => true,
        ]);
    }
}
