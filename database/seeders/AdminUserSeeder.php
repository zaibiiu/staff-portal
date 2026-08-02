<?php

namespace Database\Seeders;

use App\Models\Salary;
use App\Models\StaffProfile;
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
        User::firstOrCreate(
            ['email' => 'admin@staffportal.com'],
            [
                'name'      => 'Admin User',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // Create Sample Staff User 1
        $staff1 = User::firstOrCreate(
            ['email' => 'john@staffportal.com'],
            [
                'name'      => 'John Doe',
                'password'  => Hash::make('password'),
                'role'      => 'staff',
                'is_active' => true,
            ]
        );

        // Create Sample Staff User 2
        $staff2 = User::firstOrCreate(
            ['email' => 'jane@staffportal.com'],
            [
                'name'      => 'Jane Smith',
                'password'  => Hash::make('password'),
                'role'      => 'staff',
                'is_active' => true,
            ]
        );

        // Create Staff Profiles
        StaffProfile::firstOrCreate(
            ['user_id' => $staff1->id],
            [
                'employee_id'        => 'EMP0001',
                'phone'              => '+92 300 1234567',
                'address'            => '123 Main Street, Lahore',
                'designation'        => 'Senior Developer',
                'joining_date'       => now()->subYears(2),
                'employment_status'  => 'active',
            ]
        );

        StaffProfile::firstOrCreate(
            ['user_id' => $staff2->id],
            [
                'employee_id'        => 'EMP0002',
                'phone'              => '+92 301 7654321',
                'address'            => '456 Park Avenue, Karachi',
                'designation'        => 'UI/UX Designer',
                'joining_date'       => now()->subYear(),
                'employment_status'  => 'active',
            ]
        );

        // Create Sample Salaries
        Salary::firstOrCreate(
            ['user_id' => $staff1->id, 'is_current' => true],
            [
                'amount'         => 75000,
                'effective_date' => now()->subYears(2),
                'is_current'     => true,
            ]
        );

        Salary::firstOrCreate(
            ['user_id' => $staff2->id, 'is_current' => true],
            [
                'amount'         => 60000,
                'effective_date' => now()->subYear(),
                'is_current'     => true,
            ]
        );

        $this->command->info('✅ Admin and sample staff users created.');
    }
}
