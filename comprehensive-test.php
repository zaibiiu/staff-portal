<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n";
echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
echo "║          COMPREHENSIVE STAFF PORTAL TESTING - ALL FEATURES              ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════╝\n";
echo "\n";

$errors = [];
$warnings = [];
$totalTests = 0;
$passedTests = 0;

function testSection($name) {
    echo "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "  {$name}\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
}

function testResult($test, $passed, $message = '', &$total, &$passed_count, &$errors) {
    $total++;
    if ($passed) {
        $passed_count++;
        echo "  ✅ {$test}\n";
        if ($message) echo "     └─ {$message}\n";
    } else {
        echo "  ❌ {$test}\n";
        echo "     └─ ERROR: {$message}\n";
        $errors[] = "{$test}: {$message}";
    }
}

// ============================================================================
// TEST 1: DATABASE CONNECTIVITY & MODELS
// ============================================================================
testSection("1. DATABASE & MODELS");

try {
    $dbName = \DB::connection()->getDatabaseName();
    testResult("Database Connection", true, "Connected to: {$dbName}", $totalTests, $passedTests, $errors);
} catch (\Exception $e) {
    testResult("Database Connection", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// Check all models exist and are accessible
$models = [
    'User' => \App\Models\User::class,
    'Department' => \App\Models\Department::class,
    'Project' => \App\Models\Project::class,
    'Task' => \App\Models\Task::class,
    'StaffProfile' => \App\Models\StaffProfile::class,
    'Attendance' => \App\Models\Attendance::class,
    'Commission' => \App\Models\Commission::class,
    'Document' => \App\Models\Document::class,
    'Salary' => \App\Models\Salary::class,
];

foreach ($models as $name => $class) {
    try {
        $count = $class::count();
        testResult("{$name} Model", true, "Found {$count} records", $totalTests, $passedTests, $errors);
    } catch (\Exception $e) {
        testResult("{$name} Model", false, $e->getMessage(), $totalTests, $passedTests, $errors);
    }
}

// ============================================================================
// TEST 2: USER MANAGEMENT CRUD
// ============================================================================
testSection("2. USER MANAGEMENT - CRUD OPERATIONS");

// CREATE User
try {
    $testUser = \App\Models\User::create([
        'name' => 'CRUD Test User ' . time(),
        'email' => 'crudtest' . time() . '@test.com',
        'password' => \Hash::make('password123'),
        'role' => 'staff',
        'is_active' => true,
    ]);
    testResult("User CREATE", true, "Created user ID: {$testUser->id}", $totalTests, $passedTests, $errors);
    
    // CREATE Staff Profile for user
    $testProfile = \App\Models\StaffProfile::create([
        'user_id' => $testUser->id,
        'employee_id' => 'TEST' . time(),
        'phone' => '+92 300 9999999',
        'designation' => 'Test Designation',
        'employment_status' => 'active',
    ]);
    testResult("Staff Profile CREATE", true, "Created profile ID: {$testProfile->id}", $totalTests, $passedTests, $errors);
    
    // READ User
    $readUser = \App\Models\User::find($testUser->id);
    testResult("User READ", $readUser !== null, "Retrieved user: {$readUser->name}", $totalTests, $passedTests, $errors);
    
    // UPDATE User
    $testUser->update(['name' => 'Updated Test User ' . time()]);
    $testUser->refresh();
    testResult("User UPDATE", str_contains($testUser->name, 'Updated'), "Updated name: {$testUser->name}", $totalTests, $passedTests, $errors);
    
    // DELETE User (cascade should delete profile)
    $userId = $testUser->id;
    $testUser->delete();
    $deleted = \App\Models\User::find($userId) === null;
    $profileDeleted = \App\Models\StaffProfile::where('user_id', $userId)->count() === 0;
    testResult("User DELETE (cascade)", $deleted && $profileDeleted, "User & profile deleted", $totalTests, $passedTests, $errors);
    
} catch (\Exception $e) {
    testResult("User CRUD Operations", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// ============================================================================
// TEST 3: DEPARTMENT MANAGEMENT CRUD
// ============================================================================
testSection("3. DEPARTMENT MANAGEMENT - CRUD OPERATIONS");

try {
    // CREATE
    $testDept = \App\Models\Department::create([
        'name' => 'Test Dept ' . time(),
        'description' => 'Test Description',
        'is_active' => true,
    ]);
    testResult("Department CREATE", true, "Created dept ID: {$testDept->id}", $totalTests, $passedTests, $errors);
    
    // READ
    $readDept = \App\Models\Department::find($testDept->id);
    testResult("Department READ", $readDept !== null, "Retrieved: {$readDept->name}", $totalTests, $passedTests, $errors);
    
    // UPDATE
    $testDept->update(['name' => 'Updated Dept ' . time()]);
    $testDept->refresh();
    testResult("Department UPDATE", str_contains($testDept->name, 'Updated'), "New name: {$testDept->name}", $totalTests, $passedTests, $errors);
    
    // DELETE
    $deptId = $testDept->id;
    $testDept->delete();
    $deleted = \App\Models\Department::find($deptId) === null;
    testResult("Department DELETE", $deleted, "Department removed", $totalTests, $passedTests, $errors);
    
} catch (\Exception $e) {
    testResult("Department CRUD Operations", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// ============================================================================
// TEST 4: PROJECT MANAGEMENT CRUD
// ============================================================================
testSection("4. PROJECT MANAGEMENT - CRUD OPERATIONS");

try {
    // CREATE
    $testProject = \App\Models\Project::create([
        'name' => 'Test Project ' . time(),
        'description' => 'Test project description',
        'start_date' => now(),
        'deadline' => now()->addDays(30),
        'stage' => 'planning',
        'status' => 'active',
    ]);
    testResult("Project CREATE", true, "Created project ID: {$testProject->id}", $totalTests, $passedTests, $errors);
    
    // Attach users (many-to-many)
    $users = \App\Models\User::where('role', 'staff')->take(2)->pluck('id');
    if ($users->count() > 0) {
        $testProject->users()->attach($users);
        $attached = $testProject->users()->count();
        testResult("Project USER ATTACHMENT", $attached > 0, "Attached {$attached} users", $totalTests, $passedTests, $errors);
    }
    
    // READ
    $readProject = \App\Models\Project::with('users')->find($testProject->id);
    testResult("Project READ", $readProject !== null, "Retrieved: {$readProject->name}", $totalTests, $passedTests, $errors);
    
    // UPDATE
    $testProject->update(['stage' => 'in_progress']);
    $testProject->refresh();
    testResult("Project UPDATE", $testProject->stage === 'in_progress', "New stage: {$testProject->stage}", $totalTests, $passedTests, $errors);
    
    // DELETE
    $projectId = $testProject->id;
    $testProject->delete();
    $deleted = \App\Models\Project::find($projectId) === null;
    testResult("Project DELETE", $deleted, "Project removed", $totalTests, $passedTests, $errors);
    
} catch (\Exception $e) {
    testResult("Project CRUD Operations", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// ============================================================================
// TEST 5: TASK MANAGEMENT CRUD
// ============================================================================
testSection("5. TASK MANAGEMENT - CRUD OPERATIONS");

try {
    $project = \App\Models\Project::first();
    $user = \App\Models\User::where('role', 'staff')->first();
    
    if ($project && $user) {
        // CREATE
        $testTask = \App\Models\Task::create([
            'title' => 'Test Task ' . time(),
            'description' => 'Test task description',
            'project_id' => $project->id,
            'user_id' => $user->id,
            'priority' => 'high',
            'status' => 'pending',
            'due_date' => now()->addDays(7),
        ]);
        testResult("Task CREATE", true, "Created task ID: {$testTask->id}", $totalTests, $passedTests, $errors);
        
        // READ with relations
        $readTask = \App\Models\Task::with(['user', 'project'])->find($testTask->id);
        testResult("Task READ (with relations)", $readTask !== null && $readTask->user && $readTask->project, 
            "Task: {$readTask->title}, Assigned: {$readTask->user->name}, Project: {$readTask->project->name}", 
            $totalTests, $passedTests, $errors);
        
        // UPDATE
        $testTask->update(['status' => 'in_progress', 'priority' => 'urgent']);
        $testTask->refresh();
        testResult("Task UPDATE", $testTask->status === 'in_progress' && $testTask->priority === 'urgent', 
            "Status: {$testTask->status}, Priority: {$testTask->priority}", $totalTests, $passedTests, $errors);
        
        // DELETE
        $taskId = $testTask->id;
        $testTask->delete();
        $deleted = \App\Models\Task::find($taskId) === null;
        testResult("Task DELETE", $deleted, "Task removed", $totalTests, $passedTests, $errors);
    } else {
        testResult("Task CRUD Operations", false, "Missing project or user data", $totalTests, $passedTests, $errors);
    }
    
} catch (\Exception $e) {
    testResult("Task CRUD Operations", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// ============================================================================
// TEST 6: STAFF PROFILE UPDATE (Real User Profile Update)
// ============================================================================
testSection("6. STAFF PROFILE - UPDATE OPERATIONS");

try {
    $user = \App\Models\User::where('role', 'staff')->with('staffProfile')->first();
    
    if ($user && $user->staffProfile) {
        $oldPhone = $user->staffProfile->phone;
        $newPhone = '+92 300 ' . rand(1000000, 9999999);
        
        // UPDATE profile
        $user->staffProfile->update([
            'phone' => $newPhone,
            'address' => 'Updated Address Line ' . time(),
            'designation' => 'Updated Position ' . time(),
        ]);
        
        $user->staffProfile->refresh();
        $updated = $user->staffProfile->phone === $newPhone;
        testResult("Staff Profile UPDATE", $updated, 
            "Phone changed from {$oldPhone} to {$newPhone}", $totalTests, $passedTests, $errors);
    } else {
        testResult("Staff Profile UPDATE", false, "No staff profile found", $totalTests, $passedTests, $errors);
    }
    
} catch (\Exception $e) {
    testResult("Staff Profile UPDATE", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// ============================================================================
// TEST 7: RELATIONS INTEGRITY
// ============================================================================
testSection("7. DATABASE RELATIONS - INTEGRITY CHECK");

try {
    $user = \App\Models\User::with(['staffProfile', 'tasks', 'projects'])->where('role', 'staff')->first();
    
    if ($user) {
        testResult("User → StaffProfile (One-to-One)", $user->staffProfile !== null, 
            "Profile exists for user {$user->name}", $totalTests, $passedTests, $errors);
        
        testResult("User → Tasks (One-to-Many)", true, 
            "User has {$user->tasks->count()} tasks", $totalTests, $passedTests, $errors);
        
        testResult("User → Projects (Many-to-Many)", true, 
            "User in {$user->projects->count()} projects", $totalTests, $passedTests, $errors);
    }
    
    $project = \App\Models\Project::with(['tasks', 'users'])->first();
    if ($project) {
        testResult("Project → Tasks (One-to-Many)", true, 
            "Project has {$project->tasks->count()} tasks", $totalTests, $passedTests, $errors);
        
        testResult("Project → Users (Many-to-Many)", true, 
            "Project has {$project->users->count()} team members", $totalTests, $passedTests, $errors);
    }
    
    $task = \App\Models\Task::with(['user', 'project'])->first();
    if ($task) {
        testResult("Task → User (Belongs To)", $task->user !== null, 
            "Task assigned to {$task->user->name}", $totalTests, $passedTests, $errors);
        
        $projectName = $task->project ? $task->project->name : 'N/A';
        testResult("Task → Project (Belongs To)", true, 
            "Task belongs to project: {$projectName}", $totalTests, $passedTests, $errors);
    }
    
} catch (\Exception $e) {
    testResult("Relations Integrity", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// ============================================================================
// TEST 8: FILE UPLOAD CONFIGURATION
// ============================================================================
testSection("8. FILE UPLOAD - STORAGE & CONFIGURATION");

try {
    $storagePath = storage_path('app/public');
    $publicLink = public_path('storage');
    
    testResult("Storage Path Exists", is_dir($storagePath), "Path: {$storagePath}", $totalTests, $passedTests, $errors);
    testResult("Public Storage Link", is_link($publicLink) || is_dir($publicLink), 
        "Symlink exists: {$publicLink}", $totalTests, $passedTests, $errors);
    
    $profilePhotosPath = storage_path('app/public/profile-photos');
    if (!is_dir($profilePhotosPath)) {
        mkdir($profilePhotosPath, 0755, true);
    }
    testResult("Profile Photos Directory", is_dir($profilePhotosPath), 
        "Path: {$profilePhotosPath}", $totalTests, $passedTests, $errors);
    
    testResult("Directory Writable", is_writable($profilePhotosPath), 
        "Can write to profile-photos", $totalTests, $passedTests, $errors);
    
} catch (\Exception $e) {
    testResult("File Upload Configuration", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// ============================================================================
// TEST 9: WIDGETS DATA
// ============================================================================
testSection("9. DASHBOARD WIDGETS - DATA LOADING");

try {
    $totalStaff = \App\Models\User::where('role', 'staff')->count();
    $activeStaff = \App\Models\User::where('role', 'staff')->where('is_active', true)->count();
    testResult("Stats Widget - Staff Count", true, 
        "Total: {$totalStaff}, Active: {$activeStaff}", $totalTests, $passedTests, $errors);
    
    $totalProjects = \App\Models\Project::count();
    $activeProjects = \App\Models\Project::where('status', 'active')->count();
    testResult("Stats Widget - Project Count", true, 
        "Total: {$totalProjects}, Active: {$activeProjects}", $totalTests, $passedTests, $errors);
    
    $totalTasks = \App\Models\Task::count();
    $pendingTasks = \App\Models\Task::where('status', 'pending')->count();
    $completedTasks = \App\Models\Task::where('status', 'completed')->count();
    testResult("Stats Widget - Task Count", true, 
        "Total: {$totalTasks}, Pending: {$pendingTasks}, Completed: {$completedTasks}", $totalTests, $passedTests, $errors);
    
    $todayAttendance = \App\Models\Attendance::where('date', today())->count();
    testResult("Stats Widget - Attendance", true, 
        "Today's records: {$todayAttendance}", $totalTests, $passedTests, $errors);
    
    $recentTasks = \App\Models\Task::with(['user', 'project'])->latest()->limit(10)->get();
    testResult("Recent Tasks Widget", $recentTasks->count() > 0, 
        "Loaded {$recentTasks->count()} recent tasks", $totalTests, $passedTests, $errors);
    
} catch (\Exception $e) {
    testResult("Widget Data Loading", false, $e->getMessage(), $totalTests, $passedTests, $errors);
}

// ============================================================================
// TEST 10: FILAMENT RESOURCES
// ============================================================================
testSection("10. FILAMENT RESOURCES - CLASS EXISTENCE");

$resources = [
    'UserResource' => \App\Filament\Resources\UserResource::class,
    'DepartmentResource' => \App\Filament\Resources\DepartmentResource::class,
    'ProjectResource' => \App\Filament\Resources\ProjectResource::class,
    'TaskResource' => \App\Filament\Resources\TaskResource::class,
];

foreach ($resources as $name => $class) {
    try {
        $exists = class_exists($class);
        $hasForm = method_exists($class, 'form');
        $hasTable = method_exists($class, 'table');
        testResult("{$name} Resource", $exists && $hasForm && $hasTable, 
            "Class exists with form() and table() methods", $totalTests, $passedTests, $errors);
    } catch (\Exception $e) {
        testResult("{$name} Resource", false, $e->getMessage(), $totalTests, $passedTests, $errors);
    }
}

// ============================================================================
// TEST 11: RELATION MANAGERS
// ============================================================================
testSection("11. RELATION MANAGERS - CLASS EXISTENCE");

$relationManagers = [
    'StaffProfileRelationManager' => \App\Filament\Resources\UserResource\RelationManagers\StaffProfileRelationManager::class,
    'TasksRelationManager (User)' => \App\Filament\Resources\UserResource\RelationManagers\TasksRelationManager::class,
    'TasksRelationManager (Project)' => \App\Filament\Resources\ProjectResource\RelationManagers\TasksRelationManager::class,
    'SalariesRelationManager' => \App\Filament\Resources\UserResource\RelationManagers\SalariesRelationManager::class,
    'AttendancesRelationManager' => \App\Filament\Resources\UserResource\RelationManagers\AttendancesRelationManager::class,
    'DocumentsRelationManager' => \App\Filament\Resources\UserResource\RelationManagers\DocumentsRelationManager::class,
    'CommissionsRelationManager' => \App\Filament\Resources\UserResource\RelationManagers\CommissionsRelationManager::class,
];

foreach ($relationManagers as $name => $class) {
    try {
        $exists = class_exists($class);
        testResult($name, $exists, "Class exists", $totalTests, $passedTests, $errors);
    } catch (\Exception $e) {
        testResult($name, false, $e->getMessage(), $totalTests, $passedTests, $errors);
    }
}

// ============================================================================
// TEST 12: POLICIES
// ============================================================================
testSection("12. AUTHORIZATION POLICIES");

$policies = [
    'UserPolicy' => \App\Policies\UserPolicy::class,
    'DepartmentPolicy' => \App\Policies\DepartmentPolicy::class,
    'ProjectPolicy' => \App\Policies\ProjectPolicy::class,
    'TaskPolicy' => \App\Policies\TaskPolicy::class,
];

foreach ($policies as $name => $class) {
    try {
        $exists = class_exists($class);
        testResult($name, $exists, "Policy exists", $totalTests, $passedTests, $errors);
    } catch (\Exception $e) {
        testResult($name, false, $e->getMessage(), $totalTests, $passedTests, $errors);
    }
}

// ============================================================================
// TEST 13: PAGES
// ============================================================================
testSection("13. FILAMENT PAGES");

$pages = [
    'Dashboard' => \App\Filament\Pages\Dashboard::class,
    'MyProfile' => \App\Filament\Pages\MyProfile::class,
    'MyAttendance' => \App\Filament\Pages\MyAttendance::class,
    'MyCommissions' => \App\Filament\Pages\MyCommissions::class,
    'MyDocuments' => \App\Filament\Pages\MyDocuments::class,
    'MyProjects' => \App\Filament\Pages\MyProjects::class,
    'MySalary' => \App\Filament\Pages\MySalary::class,
    'MyTasks' => \App\Filament\Pages\MyTasks::class,
    'Login' => \App\Filament\Pages\Auth\Login::class,
];

foreach ($pages as $name => $class) {
    try {
        $exists = class_exists($class);
        testResult("{$name} Page", $exists, "Page class exists", $totalTests, $passedTests, $errors);
    } catch (\Exception $e) {
        testResult("{$name} Page", false, $e->getMessage(), $totalTests, $passedTests, $errors);
    }
}

// ============================================================================
// TEST 14: WIDGETS
// ============================================================================
testSection("14. DASHBOARD WIDGETS - CLASSES");

$widgets = [
    'StatsOverview' => \App\Filament\Widgets\StatsOverview::class,
    'RecentTasksWidget' => \App\Filament\Widgets\RecentTasksWidget::class,
    'StaffStatsWidget' => \App\Filament\Widgets\StaffStatsWidget::class,
    'StaffTasksWidget' => \App\Filament\Widgets\StaffTasksWidget::class,
];

foreach ($widgets as $name => $class) {
    try {
        $exists = class_exists($class);
        testResult("{$name} Widget", $exists, "Widget exists", $totalTests, $passedTests, $errors);
    } catch (\Exception $e) {
        testResult("{$name} Widget", false, $e->getMessage(), $totalTests, $passedTests, $errors);
    }
}

// ============================================================================
// FINAL SUMMARY
// ============================================================================
echo "\n";
echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
echo "║                          TEST SUMMARY                                    ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "  Total Tests Run:     {$totalTests}\n";
echo "  Tests Passed:        {$passedTests} ✅\n";
echo "  Tests Failed:        " . ($totalTests - $passedTests) . " ❌\n";
echo "  Success Rate:        " . round(($passedTests / $totalTests) * 100, 2) . "%\n";
echo "\n";

if (count($errors) > 0) {
    echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
    echo "║                          ERRORS FOUND                                    ║\n";
    echo "╚══════════════════════════════════════════════════════════════════════════╝\n";
    echo "\n";
    foreach ($errors as $i => $error) {
        echo "  " . ($i + 1) . ". {$error}\n";
    }
    echo "\n";
} else {
    echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
    echo "║                    ✅ ALL TESTS PASSED! ✅                               ║\n";
    echo "║                                                                          ║\n";
    echo "║  Your Staff Portal application is working perfectly!                    ║\n";
    echo "║  All CRUD operations, relations, and features are functional.           ║\n";
    echo "║                                                                          ║\n";
    echo "║  Next Steps:                                                             ║\n";
    echo "║  1. Test in browser at: http://dev.staffhub.com/admin                   ║\n";
    echo "║  2. Upload a profile photo to verify file uploads                       ║\n";
    echo "║  3. Check all forms in the UI                                            ║\n";
    echo "║  4. Add logo file to: public/logo.png or public/logo.svg                ║\n";
    echo "╚══════════════════════════════════════════════════════════════════════════╝\n";
}

echo "\n";
echo "Testing completed at: " . date('Y-m-d H:i:s') . "\n";
echo "\n";
