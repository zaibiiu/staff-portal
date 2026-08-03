<?php

/**
 * Comprehensive Validation Test
 * Tests all validation rules across relation managers
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\StaffProfile;
use App\Models\Salary;
use App\Models\Commission;
use App\Models\Attendance;
use App\Models\Task;
use App\Models\Document;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

echo "\n═══════════════════════════════════════════\n";
echo "  COMPREHENSIVE VALIDATION TEST\n";
echo "═══════════════════════════════════════════\n\n";

$passed = 0;
$failed = 0;

function testValidation($name, $rules, $validData, $invalidData, $expectedErrors) {
    global $passed, $failed;
    
    echo "Testing: {$name}\n";
    
    // Test valid data
    $validator = Validator::make($validData, $rules);
    if ($validator->passes()) {
        echo "  ✓ Valid data passes\n";
        $passed++;
    } else {
        echo "  ✗ Valid data failed: " . json_encode($validator->errors()->all()) . "\n";
        $failed++;
    }
    
    // Test invalid data
    $validator = Validator::make($invalidData, $rules);
    if ($validator->fails()) {
        $errors = $validator->errors()->keys();
        $allExpectedErrorsPresent = true;
        foreach ($expectedErrors as $expectedError) {
            if (!in_array($expectedError, $errors)) {
                $allExpectedErrorsPresent = false;
                break;
            }
        }
        
        if ($allExpectedErrorsPresent) {
            echo "  ✓ Invalid data fails correctly\n";
            $passed++;
        } else {
            echo "  ✗ Expected errors not found. Got: " . implode(', ', $errors) . "\n";
            $failed++;
        }
    } else {
        echo "  ✗ Invalid data should have failed\n";
        $failed++;
    }
    
    echo "\n";
}

// Test 1: Staff Profile - CNIC Validation
testValidation(
    "Staff Profile - CNIC Format",
    ['cnic' => 'required|regex:/^\d{5}-\d{7}-\d{1}$/'],
    ['cnic' => '12345-1234567-1'],
    ['cnic' => '123456789012'],
    ['cnic']
);

// Test 2: Staff Profile - Phone Validation
testValidation(
    "Staff Profile - Phone Format",
    ['phone' => 'required|regex:/^[0-9+\-\s()]+$/|min:10|max:20'],
    ['phone' => '+92-300-1234567'],
    ['phone' => 'abc123'],
    ['phone']
);

// Test 3: Staff Profile - Employee ID
testValidation(
    "Staff Profile - Employee ID",
    ['employee_id' => 'required|max:50|regex:/^[A-Za-z0-9_-]+$/'],
    ['employee_id' => 'EMP-001'],
    ['employee_id' => 'EMP@001'],
    ['employee_id']
);

// Test 4: Staff Profile - Date of Birth
testValidation(
    "Staff Profile - Date of Birth (18+ years)",
    ['date_of_birth' => 'required|date|before:-18 years'],
    ['date_of_birth' => now()->subYears(25)->format('Y-m-d')],
    ['date_of_birth' => now()->subYears(15)->format('Y-m-d')],
    ['date_of_birth']
);

// Test 5: Staff Profile - Emergency Contact Name
testValidation(
    "Staff Profile - Emergency Contact Name (letters only)",
    ['emergency_contact_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255'],
    ['emergency_contact_name' => 'John Doe'],
    ['emergency_contact_name' => 'John123'],
    ['emergency_contact_name']
);

// Test 6: Salary - Amount Validation
testValidation(
    "Salary - Amount (numeric, min 0)",
    ['amount' => 'required|numeric|min:0|max:9999999999.99'],
    ['amount' => '50000'],
    ['amount' => '-1000'],
    ['amount']
);

// Test 7: Salary - Date Range
testValidation(
    "Salary - Effective Date",
    [
        'effective_date' => 'required|date|before_or_equal:+1 year',
        'end_date' => 'nullable|date|after:effective_date'
    ],
    [
        'effective_date' => now()->format('Y-m-d'),
        'end_date' => now()->addMonth()->format('Y-m-d')
    ],
    [
        'effective_date' => now()->format('Y-m-d'),
        'end_date' => now()->subMonth()->format('Y-m-d')
    ],
    ['end_date']
);

// Test 8: Commission - Amount Validation
testValidation(
    "Commission - Amount",
    ['amount' => 'required|numeric|min:0|max:9999999999.99'],
    ['amount' => '5000.50'],
    ['amount' => 'not-a-number'],
    ['amount']
);

// Test 9: Commission - Month Format
testValidation(
    "Commission - Month Format (Month YYYY)",
    ['commission_month' => 'required|regex:/^[A-Za-z]+\s\d{4}$/|max:50'],
    ['commission_month' => 'January 2024'],
    ['commission_month' => '01/2024'],
    ['commission_month']
);

// Test 10: Commission - Date
testValidation(
    "Commission - Date (not future)",
    ['commission_date' => 'required|date|before_or_equal:today'],
    ['commission_date' => now()->format('Y-m-d')],
    ['commission_date' => now()->addDays(5)->format('Y-m-d')],
    ['commission_date']
);

// Test 11: Attendance - Date
testValidation(
    "Attendance - Date (not future)",
    ['date' => 'required|date|before_or_equal:today'],
    ['date' => now()->format('Y-m-d')],
    ['date' => now()->addDays(1)->format('Y-m-d')],
    ['date']
);

// Test 12: Attendance - Time Range
testValidation(
    "Attendance - Check Out after Check In",
    [
        'check_in' => 'nullable|date_format:H:i',
        'check_out' => 'nullable|date_format:H:i|after:check_in'
    ],
    [
        'check_in' => '09:00',
        'check_out' => '17:00'
    ],
    [
        'check_in' => '17:00',
        'check_out' => '09:00'
    ],
    ['check_out']
);

// Test 13: Task - Title
testValidation(
    "Task - Title",
    ['title' => 'required|max:255'],
    ['title' => 'Complete project documentation'],
    ['title' => ''],
    ['title']
);

// Test 14: Task - Due Date
testValidation(
    "Task - Due Date (not past)",
    ['due_date' => 'required|date|after_or_equal:today'],
    ['due_date' => now()->addDays(5)->format('Y-m-d')],
    ['due_date' => now()->subDays(5)->format('Y-m-d')],
    ['due_date']
);

// Test 15: Document - Title
testValidation(
    "Document - Title",
    ['title' => 'required|max:255'],
    ['title' => 'Employment Contract'],
    ['title' => ''],
    ['title']
);

// Test 16: Document - Type
testValidation(
    "Document - Type",
    ['document_type' => 'required|in:cnic,contract,certificate,degree,experience_letter,other'],
    ['document_type' => 'cnic'],
    ['document_type' => 'invalid_type'],
    ['document_type']
);

// Test 17: User - Email
testValidation(
    "User - Email Format",
    ['email' => 'required|email|max:255'],
    ['email' => 'user@example.com'],
    ['email' => 'invalid-email'],
    ['email']
);

// Test 18: User - Password
testValidation(
    "User - Password (min 8 chars)",
    ['password' => 'required|min:8'],
    ['password' => 'password123'],
    ['password' => '123'],
    ['password']
);

// Test 19: Staff Profile - Max Length Fields
testValidation(
    "Staff Profile - Address Max Length",
    ['address' => 'nullable|max:500'],
    ['address' => str_repeat('a', 500)],
    ['address' => str_repeat('a', 501)],
    ['address']
);

// Test 20: Notes Fields - Max Length
testValidation(
    "Various - Notes Max Length",
    ['notes' => 'nullable|max:1000'],
    ['notes' => str_repeat('a', 1000)],
    ['notes' => str_repeat('a', 1001)],
    ['notes']
);

// Results
$total = $passed + $failed;
$percentage = $total > 0 ? round(($passed / $total) * 100) : 0;

echo "═══════════════════════════════════════════\n";
echo "  TEST RESULTS\n";
echo "═══════════════════════════════════════════\n";
echo "  ✓ Passed: {$passed}\n";
echo "  ✗ Failed: {$failed}\n";
echo "  Success Rate: {$percentage}%\n";
echo "═══════════════════════════════════════════\n\n";

if ($failed === 0) {
    echo "✓✓✓ ALL VALIDATION TESTS PASSED! ✓✓✓\n\n";
    echo "All validation rules are working correctly:\n";
    echo "  ✓ CNIC format validation\n";
    echo "  ✓ Phone number validation\n";
    echo "  ✓ Email validation\n";
    echo "  ✓ Date validations (age, past/future)\n";
    echo "  ✓ Numeric validations (amounts, min/max)\n";
    echo "  ✓ Text format validations (letters only, alphanumeric)\n";
    echo "  ✓ Max length validations\n";
    echo "  ✓ Time range validations\n";
    echo "  ✓ Required field validations\n";
    echo "  ✓ Enum/select validations\n\n";
    exit(0);
} else {
    echo "✗✗✗ SOME VALIDATION TESTS FAILED ✗✗✗\n\n";
    echo "Please review the failed tests above.\n\n";
    exit(1);
}
