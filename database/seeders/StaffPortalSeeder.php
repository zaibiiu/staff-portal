<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Commission;
use App\Models\Department;
use App\Models\Document;
use App\Models\Project;
use App\Models\Salary;
use App\Models\StaffProfile;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffPortalSeeder extends Seeder
{
    public function run(): void
    {
        // ────────────────────────────────────────────────────────────
        // 1. DEPARTMENTS (10 records)
        // ────────────────────────────────────────────────────────────
        $departments = [
            ['name' => 'Information Technology',     'description' => 'Software development, infrastructure, and IT support'],
            ['name' => 'Human Resources',            'description' => 'Recruitment, onboarding, and employee management'],
            ['name' => 'Finance & Accounts',         'description' => 'Financial planning, bookkeeping, and reporting'],
            ['name' => 'Marketing',                  'description' => 'Brand management, campaigns, and digital marketing'],
            ['name' => 'Sales',                      'description' => 'Business development and client acquisition'],
            ['name' => 'Operations',                 'description' => 'Business operations, logistics, and process management'],
            ['name' => 'Customer Support',           'description' => 'Client relations, helpdesk, and after-sales service'],
            ['name' => 'Design & Creative',          'description' => 'UI/UX design, graphics, and content creation'],
            ['name' => 'Quality Assurance',          'description' => 'Testing, quality control, and process improvement'],
            ['name' => 'Administration',             'description' => 'Office management, procurement, and admin support'],
        ];

        $createdDepts = [];
        foreach ($departments as $dept) {
            $createdDepts[] = Department::firstOrCreate(['name' => $dept['name']], $dept);
        }

        // ────────────────────────────────────────────────────────────
        // 2. STAFF USERS (10 records)
        // ────────────────────────────────────────────────────────────
        $staffData = [
            ['name' => 'Ahmed Hassan',      'email' => 'ahmed@staffportal.com',      'dept' => 0, 'designation' => 'Senior PHP Developer',     'salary' => 85000, 'cnic' => '35202-1234567-1'],
            ['name' => 'Sara Khan',         'email' => 'sara@staffportal.com',        'dept' => 1, 'designation' => 'HR Manager',               'salary' => 75000, 'cnic' => '35202-7654321-2'],
            ['name' => 'Bilal Ahmed',       'email' => 'bilal@staffportal.com',       'dept' => 2, 'designation' => 'Accounts Officer',          'salary' => 65000, 'cnic' => '35202-1122334-3'],
            ['name' => 'Fatima Malik',      'email' => 'fatima@staffportal.com',      'dept' => 3, 'designation' => 'Digital Marketing Lead',    'salary' => 70000, 'cnic' => '35202-4433221-4'],
            ['name' => 'Usman Ali',         'email' => 'usman@staffportal.com',       'dept' => 4, 'designation' => 'Sales Executive',           'salary' => 55000, 'cnic' => '35202-5566778-5'],
            ['name' => 'Ayesha Siddiqui',   'email' => 'ayesha@staffportal.com',      'dept' => 5, 'designation' => 'Operations Manager',        'salary' => 80000, 'cnic' => '35202-8877665-6'],
            ['name' => 'Zain Ul Abideen',   'email' => 'zain@staffportal.com',        'dept' => 6, 'designation' => 'Customer Support Lead',     'salary' => 50000, 'cnic' => '35202-9988776-7'],
            ['name' => 'Mariam Tahir',      'email' => 'mariam@staffportal.com',      'dept' => 7, 'designation' => 'Senior UI/UX Designer',     'salary' => 72000, 'cnic' => '35202-1231231-8'],
            ['name' => 'Hamza Raza',        'email' => 'hamza@staffportal.com',       'dept' => 8, 'designation' => 'QA Engineer',               'salary' => 60000, 'cnic' => '35202-3213213-9'],
            ['name' => 'Nadia Javed',       'email' => 'nadia@staffportal.com',       'dept' => 9, 'designation' => 'Admin Coordinator',         'salary' => 48000, 'cnic' => '35202-6546549-0'],
        ];

        $staffUsers = [];
        foreach ($staffData as $i => $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'      => $data['name'],
                    'password'  => Hash::make('password'),
                    'role'      => 'staff',
                    'is_active' => true,
                ]
            );

            // Create Staff Profile
            $employeeNum = $i + 3; // Offset from admin + 2 existing
            StaffProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'employee_id'           => 'EMP' . str_pad($employeeNum, 4, '0', STR_PAD_LEFT),
                    'department_id'         => $createdDepts[$data['dept']]->id,
                    'designation'           => $data['designation'],
                    'phone'                 => '+92 3' . rand(00, 99) . ' ' . rand(1000000, 9999999),
                    'address'               => 'House ' . rand(1, 200) . ', Street ' . rand(1, 50) . ', Lahore',
                    'cnic'                  => $data['cnic'],
                    'joining_date'          => Carbon::now()->subMonths(rand(6, 36)),
                    'date_of_birth'         => Carbon::now()->subYears(rand(24, 40))->subMonths(rand(0, 11)),
                    'emergency_contact_name'=> 'Emergency Contact ' . ($i + 1),
                    'emergency_contact'     => '+92 300 ' . rand(1000000, 9999999),
                    'employment_status'     => 'active',
                    'notes'                 => 'Performance review due in Q' . rand(1, 4),
                ]
            );

            // Create Salary Records
            Salary::firstOrCreate(
                ['user_id' => $user->id, 'is_current' => true],
                [
                    'amount'         => $data['salary'],
                    'effective_date' => Carbon::now()->subMonths(rand(1, 12)),
                    'is_current'     => true,
                    'remarks'        => 'Annual salary review',
                ]
            );

            $staffUsers[] = $user;
        }

        // ────────────────────────────────────────────────────────────
        // 3. PROJECTS (10 records)
        // ────────────────────────────────────────────────────────────
        $projectsData = [
            ['name' => 'Staff Portal Development',      'stage' => 'in_progress', 'status' => 'active',    'months_back' => 3],
            ['name' => 'HR Management System',          'stage' => 'completed',   'status' => 'completed',  'months_back' => 8],
            ['name' => 'E-Commerce Website Redesign',   'stage' => 'planning',    'status' => 'active',    'months_back' => 1],
            ['name' => 'Mobile App Development',        'stage' => 'in_progress', 'status' => 'active',    'months_back' => 2],
            ['name' => 'CRM Integration',               'stage' => 'review',      'status' => 'active',    'months_back' => 4],
            ['name' => 'Marketing Automation Tool',     'stage' => 'pending',     'status' => 'on_hold',   'months_back' => 1],
            ['name' => 'Data Analytics Dashboard',      'stage' => 'in_progress', 'status' => 'active',    'months_back' => 5],
            ['name' => 'Client Onboarding Portal',      'stage' => 'completed',   'status' => 'completed', 'months_back' => 10],
            ['name' => 'Inventory Management System',   'stage' => 'planning',    'status' => 'active',    'months_back' => 0],
            ['name' => 'Internal Chat Application',     'stage' => 'in_progress', 'status' => 'active',    'months_back' => 3],
        ];

        $createdProjects = [];
        foreach ($projectsData as $i => $pData) {
            $project = Project::firstOrCreate(
                ['name' => $pData['name']],
                [
                    'description' => 'This project focuses on ' . strtolower($pData['name']) . ' for the organization.',
                    'start_date'  => Carbon::now()->subMonths($pData['months_back']),
                    'deadline'    => Carbon::now()->addMonths(rand(1, 6)),
                    'stage'       => $pData['stage'],
                    'status'      => $pData['status'],
                ]
            );

            // Assign 3-5 staff to each project
            $assignedStaff = collect($staffUsers)->random(rand(3, 5))->pluck('id')->toArray();
            $project->users()->syncWithoutDetaching($assignedStaff);

            $createdProjects[] = $project;
        }

        // ────────────────────────────────────────────────────────────
        // 4. TASKS (10+ records)
        // ────────────────────────────────────────────────────────────
        $taskTemplates = [
            ['title' => 'Database Schema Design',         'priority' => 'high',   'status' => 'completed'],
            ['title' => 'Frontend UI Implementation',     'priority' => 'high',   'status' => 'in_progress'],
            ['title' => 'API Development & Integration',  'priority' => 'urgent', 'status' => 'in_progress'],
            ['title' => 'Unit Testing & QA Review',       'priority' => 'medium', 'status' => 'pending'],
            ['title' => 'Documentation Writing',          'priority' => 'low',    'status' => 'pending'],
            ['title' => 'Code Review & Refactoring',      'priority' => 'medium', 'status' => 'in_progress'],
            ['title' => 'Performance Optimization',       'priority' => 'high',   'status' => 'pending'],
            ['title' => 'Security Audit',                 'priority' => 'urgent', 'status' => 'pending'],
            ['title' => 'Deployment & DevOps Setup',      'priority' => 'high',   'status' => 'completed'],
            ['title' => 'Client Presentation Prep',       'priority' => 'medium', 'status' => 'completed'],
            ['title' => 'Bug Fixing & Hotfixes',          'priority' => 'urgent', 'status' => 'in_progress'],
            ['title' => 'Data Migration Scripts',         'priority' => 'high',   'status' => 'pending'],
        ];

        foreach ($taskTemplates as $i => $tData) {
            $randomUser    = $staffUsers[array_rand($staffUsers)];
            $randomProject = $createdProjects[array_rand($createdProjects)];

            Task::firstOrCreate(
                ['title' => $tData['title'], 'user_id' => $randomUser->id],
                [
                    'project_id'  => $randomProject->id,
                    'description' => 'Task: ' . $tData['title'] . '. Assigned as part of ' . $randomProject->name . '.',
                    'priority'    => $tData['priority'],
                    'status'      => $tData['status'],
                    'due_date'    => Carbon::now()->addDays(rand(1, 30)),
                ]
            );
        }

        // ────────────────────────────────────────────────────────────
        // 5. COMMISSIONS (10+ records)
        // ────────────────────────────────────────────────────────────
        $commissionData = [
            ['amount' => 15000, 'desc' => 'Q1 Sales Bonus - New client acquisition'],
            ['amount' => 8500,  'desc' => 'Project completion bonus - E-Commerce Site'],
            ['amount' => 12000, 'desc' => 'Performance incentive - Q2'],
            ['amount' => 5000,  'desc' => 'Referral commission - New business'],
            ['amount' => 20000, 'desc' => 'Annual performance bonus'],
            ['amount' => 7500,  'desc' => 'Client retention bonus'],
            ['amount' => 10000, 'desc' => 'Q3 Sales target achievement'],
            ['amount' => 6000,  'desc' => 'Upselling commission - Premium package'],
            ['amount' => 9000,  'desc' => 'Team lead incentive - Project delivery'],
            ['amount' => 11500, 'desc' => 'Q4 Quarterly bonus'],
            ['amount' => 3500,  'desc' => 'Training completion incentive'],
        ];

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October'];
        foreach ($commissionData as $i => $cData) {
            $randomUser = $staffUsers[$i % count($staffUsers)];
            $monthBack  = count($commissionData) - $i;

            Commission::firstOrCreate(
                ['user_id' => $randomUser->id, 'commission_month' => $months[$i % count($months)] . ' 2025'],
                [
                    'amount'           => $cData['amount'],
                    'commission_date'  => Carbon::now()->subMonths($monthBack)->startOfMonth(),
                    'commission_month' => $months[$i % count($months)] . ' 2025',
                    'description'      => $cData['desc'],
                ]
            );
        }

        // ────────────────────────────────────────────────────────────
        // 6. ATTENDANCE (10 records per staff for last 2 weeks)
        // ────────────────────────────────────────────────────────────
        $statuses = ['present', 'present', 'present', 'present', 'late', 'present', 'present', 'absent', 'leave', 'present'];
        $checkIns = ['08:30:00', '08:45:00', '09:00:00', '09:15:00', '09:30:00', '08:55:00', '09:05:00', null, null, '08:40:00'];

        foreach ($staffUsers as $user) {
            foreach (range(0, 9) as $dayOffset) {
                $date = Carbon::now()->subDays($dayOffset + 1);
                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }

                $statusIndex = $dayOffset % count($statuses);
                $status      = $statuses[$statusIndex];
                $checkIn     = $checkIns[$statusIndex];

                Attendance::firstOrCreate(
                    ['user_id' => $user->id, 'date' => $date->toDateString()],
                    [
                        'status'    => $status,
                        'check_in'  => $checkIn,
                        'check_out' => $checkIn ? Carbon::parse($checkIn)->addHours(8)->format('H:i:s') : null,
                        'remarks'   => $status === 'absent' ? 'Absent without prior notice' :
                                      ($status === 'leave' ? 'Approved leave' :
                                      ($status === 'late'  ? 'Traffic delay' : null)),
                    ]
                );
            }
        }

        $this->command->info('✅ Staff Portal seeder completed successfully!');
        $this->command->info('   • ' . count($departments) . ' Departments created');
        $this->command->info('   • ' . count($staffData) . ' Staff members created');
        $this->command->info('   • ' . count($projectsData) . ' Projects created');
        $this->command->info('   • ' . count($taskTemplates) . ' Tasks created');
        $this->command->info('   • ' . count($commissionData) . ' Commission records created');
        $this->command->info('   • Attendance records created for last 10 working days');
    }
}
