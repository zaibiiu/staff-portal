<?php

/**
 * Download dummy profile images from pravatar.cc and a sample PDF
 * Run from project root: php download_avatars.php
 */

$profileDir = __DIR__ . '/storage/app/public/profile-photos';
$documentDir = __DIR__ . '/storage/app/public/documents';

if (!is_dir($profileDir)) {
    mkdir($profileDir, 0755, true);
}
if (!is_dir($documentDir)) {
    mkdir($documentDir, 0755, true);
}

function downloadFile(string $url, string $savePath, string $label): bool
{
    echo "  Downloading {$label}... ";

    $context = stream_context_create([
        'http' => [
            'timeout'         => 30,
            'follow_location' => true,
            'user_agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'header'          => "Accept: */*\r\n",
        ],
        'ssl' => [
            'verify_peer'      => false,
            'verify_peer_name' => false,
        ],
    ]);

    $data = @file_get_contents($url, false, $context);

    if ($data === false || strlen($data) < 500) {
        echo "FAILED (trying fallback)\n";
        return false;
    }

    file_put_contents($savePath, $data);
    echo "OK (" . round(strlen($data) / 1024, 1) . " KB)\n";
    return true;
}

// ─── PROFILE PHOTOS ─────────────────────────────────────────────────────────
// pravatar.cc provides 70 unique real-looking photos numbered 1-70
// We use specific IDs to get a nice variety of male/female avatars

echo "\n========================================\n";
echo "  Downloading Profile Photos\n";
echo "========================================\n";

$avatars = [
    // [filename, pravatar_id, label]
    ['avatar_admin.jpg',   12, 'Admin (male, professional)'],
    ['avatar_staff1.jpg',  47, 'Staff - Sarah Johnson (female)'],
    ['avatar_staff2.jpg',  33, 'Staff - Michael Chen (male, Asian)'],
    ['avatar_staff3.jpg',  64, 'Staff - Emily Rodriguez (female, Latin)'],
    ['avatar_staff4.jpg',   5, 'Staff - James Williams (male)'],
    ['avatar_staff5.jpg',  44, 'Staff - Fatima Al-Hassan (female)'],
    ['avatar_staff6.jpg',  22, 'Staff - David Kim (male, Asian)'],
    ['avatar_staff7.jpg',  56, 'Staff - Priya Sharma (female)'],
    ['avatar_staff8.jpg',  15, 'Staff - Omar Abdullah (male)'],
    ['avatar_staff9.jpg',  61, 'Staff - Aisha Malik (female)'],
    ['avatar_staff10.jpg', 10, 'Staff - Lucas Fernandez (male)'],
    ['avatar_staff11.jpg', 48, 'Staff - Zara Ahmed (female)'],
];

$downloaded = [];
foreach ($avatars as [$filename, $id, $label]) {
    $savePath = $profileDir . '/' . $filename;

    // Try pravatar.cc first (real photos, size 200x200)
    $url = "https://i.pravatar.cc/200?img={$id}";
    $ok  = downloadFile($url, $savePath, $label);

    if (!$ok) {
        // Fallback: UI Avatars (generates nice letter-based avatars)
        $name    = explode(' - ', $label)[1] ?? 'User';
        $nameEnc = urlencode($name);
        $colors  = ['4f46e5', '0ea5e9', '10b981', 'f59e0b', 'ef4444', '8b5cf6', 'ec4899'];
        $bg      = $colors[array_rand($colors)];
        $url2    = "https://ui-avatars.com/api/?name={$nameEnc}&size=200&background={$bg}&color=ffffff&bold=true&format=png";
        downloadFile($url2, $savePath, "{$label} (fallback)");
    }

    $downloaded[$filename] = $filename;
}

// ─── PDF DOCUMENTS ──────────────────────────────────────────────────────────
echo "\n========================================\n";
echo "  Generating Professional PDF Docs\n";
echo "========================================\n";

// Create professional-looking PDFs manually (valid PDF structure)
$pdfDocs = [
    'employment_contract.pdf'    => ['Employment Contract',        'This Employment Agreement is entered into between Staff Portal Pvt. Ltd. (the "Company") and the Employee named herein. The Employee agrees to the terms and conditions set forth in this contract. Employment is on a permanent basis subject to satisfactory performance. Notice period: 1 month. Probation: 3 months.'],
    'nda_agreement.pdf'          => ['Non-Disclosure Agreement',   'This Non-Disclosure Agreement ("NDA") is entered into to protect the proprietary information of Staff Portal Pvt. Ltd. The Employee agrees not to disclose, share, or use any confidential company information for personal gain or to the benefit of a competitor. This NDA is valid for the duration of employment and 2 years thereafter.'],
    'salary_slip_jan_2026.pdf'   => ['Salary Slip - January 2026', 'SALARY STATEMENT | Month: January 2026 | Basic Salary: PKR 90,000 | HRA: PKR 15,000 | Conveyance: PKR 5,000 | Performance Bonus: PKR 10,000 | Gross Salary: PKR 120,000 | Tax Deduction: PKR 8,500 | Net Payable: PKR 111,500'],
    'salary_slip_feb_2026.pdf'   => ['Salary Slip - February 2026','SALARY STATEMENT | Month: February 2026 | Basic Salary: PKR 90,000 | HRA: PKR 15,000 | Conveyance: PKR 5,000 | Performance Bonus: PKR 5,000 | Gross Salary: PKR 115,000 | Tax Deduction: PKR 8,200 | Net Payable: PKR 106,800'],
    'salary_slip_mar_2026.pdf'   => ['Salary Slip - March 2026',   'SALARY STATEMENT | Month: March 2026 | Basic Salary: PKR 90,000 | HRA: PKR 15,000 | Conveyance: PKR 5,000 | Performance Bonus: PKR 12,000 | Gross Salary: PKR 122,000 | Tax Deduction: PKR 8,800 | Net Payable: PKR 113,200'],
    'performance_review_2025.pdf'=> ['Performance Review 2025',    'ANNUAL PERFORMANCE REVIEW FY 2025 | Employee: Emily Rodriguez | Department: Sales & Marketing | Reviewing Manager: Admin User | Overall Rating: 4.5 / 5.0 (Excellent) | Goals Achieved: 92% | Key Achievements: Led Q3 campaign with 38% conversion rate. Exceeded sales target by PKR 1.2M. Recommendation: Consider for Senior Manager role in Q2 2026.'],
    'leave_policy.pdf'           => ['Leave Policy Document',      'STAFF LEAVE POLICY 2026 | Annual Leave: 21 days | Sick Leave: 10 days | Casual Leave: 7 days | Maternity Leave: 90 days | Paternity Leave: 14 days | Bereavement Leave: 5 days | Remote Work: Up to 5 days/month subject to manager approval. All leaves must be applied at least 48 hours in advance via the staff portal.'],
    'hr_handbook.pdf'            => ['HR Policy Handbook 2026',    'STAFF PORTAL PVT. LTD. - HR HANDBOOK 2026 | This handbook outlines company policies, code of conduct, workplace ethics, grievance procedures, and employee benefits. All employees are required to read and acknowledge this handbook within 30 days of joining. Key policies include: Anti-harassment policy, Data security policy, Social media policy, Expense reimbursement policy, and Disciplinary procedures.'],
    'tax_certificate_2025.pdf'   => ['Tax Certificate FY 2025',    'CERTIFICATE OF TAX DEDUCTION AT SOURCE | Financial Year: 2025-2026 | Employer: Staff Portal Pvt. Ltd. | NTN: 1234567-8 | Total Gross Salary Paid: PKR 1,440,000 | Total Tax Deducted: PKR 102,000 | Balance Tax Payable: PKR 0 | This certificate is issued under the Income Tax Ordinance 2001.'],
    'promotion_letter.pdf'       => ['Promotion Letter',           'PROMOTION LETTER | Date: March 15, 2026 | Dear Priya Sharma, We are pleased to inform you that effective April 1, 2026, you have been promoted to the position of Senior UI/UX Designer. Your dedication, creativity, and leadership in delivering exceptional design work has been recognized. Your revised salary will be PKR 95,000 per month. Congratulations on this well-deserved achievement!'],
    'project_contract.pdf'       => ['Project Contract',           'PROJECT AGREEMENT | Project: Staff Portal v2.0 Redesign | Client: Internal | Start Date: October 1, 2025 | End Date: June 30, 2026 | Project Budget: PKR 2,500,000 | Project Lead: Sarah Johnson | Scope: Full redesign of the staff portal including new UI components, performance optimization, mobile responsiveness, and integration with new HR APIs.'],
    'warning_letter_template.pdf'=> ['Warning Letter Template',    'WARNING LETTER TEMPLATE | This serves as an official warning regarding [specific conduct/performance issue]. The management has noted the following concern: [details of issue]. You are expected to improve the above within 30 days of this letter. Failure to improve may result in further disciplinary action up to and including termination of employment. HR Department | Staff Portal Pvt. Ltd.'],
];

foreach ($pdfDocs as $filename => $data) {
    [$title, $body] = $data;
    $filePath = $documentDir . '/' . $filename;

    echo "  Generating {$filename}... ";

    // Build a clean, valid PDF with real content
    $pdf = buildPdf($title, $body);
    file_put_contents($filePath, $pdf);

    echo "OK (" . round(strlen($pdf) / 1024, 1) . " KB)\n";
}

echo "\n========================================\n";
echo "  ALL DONE!\n";
echo "  Profile photos: {$profileDir}\n";
echo "  PDF documents:  {$documentDir}\n";
echo "========================================\n\n";

// ─── PDF BUILDER ─────────────────────────────────────────────────────────────

function buildPdf(string $title, string $body): string
{
    // Wrap body text into lines of ~80 chars
    $lines    = wordwrap($body, 80, "\n", true);
    $textLines = explode("\n", $lines);

    // Build PDF stream content
    $streamContent = "BT\n";
    // Title
    $streamContent .= "/F2 18 Tf\n";
    $streamContent .= "50 750 Td\n";
    $streamContent .= pdfString("STAFF PORTAL PVT. LTD.") . " Tj\n";
    $streamContent .= "0 -28 Td\n";
    $streamContent .= "/F2 14 Tf\n";
    $streamContent .= pdfString($title) . " Tj\n";
    // Divider line via underline simulation with dashes
    $streamContent .= "0 -8 Td\n";
    $streamContent .= "/F1 10 Tf\n";
    $streamContent .= pdfString(str_repeat('-', 85)) . " Tj\n";
    $streamContent .= "0 -18 Td\n";
    // Body text
    $streamContent .= "/F1 11 Tf\n";
    foreach ($textLines as $line) {
        $streamContent .= pdfString($line) . " Tj\n";
        $streamContent .= "0 -16 Td\n";
    }
    // Footer
    $streamContent .= "0 -30 Td\n";
    $streamContent .= "/F1 9 Tf\n";
    $streamContent .= pdfString(str_repeat('-', 85)) . " Tj\n";
    $streamContent .= "0 -14 Td\n";
    $streamContent .= pdfString("Generated by Staff Portal Management System  |  Confidential Document  |  " . date('d M Y')) . " Tj\n";
    $streamContent .= "ET\n";

    $streamLen = strlen($streamContent);

    // Build objects
    $obj1 = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
    $obj2 = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
    $obj3 = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 842]\n"
          . "/Contents 4 0 R /Resources << /Font << /F1 5 0 R /F2 6 0 R >> >> >>\nendobj\n";
    $obj4 = "4 0 obj\n<< /Length {$streamLen} >>\nstream\n{$streamContent}endstream\nendobj\n";
    $obj5 = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>\nendobj\n";
    $obj6 = "6 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>\nendobj\n";

    // Calculate xref offsets
    $header  = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
    $offset1 = strlen($header);
    $offset2 = $offset1 + strlen($obj1);
    $offset3 = $offset2 + strlen($obj2);
    $offset4 = $offset3 + strlen($obj3);
    $offset5 = $offset4 + strlen($obj4);
    $offset6 = $offset5 + strlen($obj5);

    $body = $obj1 . $obj2 . $obj3 . $obj4 . $obj5 . $obj6;

    $xrefOffset = strlen($header) + strlen($body);

    $xref = "xref\n"
        . "0 7\n"
        . "0000000000 65535 f \n"
        . sprintf("%010d", $offset1) . " 00000 n \n"
        . sprintf("%010d", $offset2) . " 00000 n \n"
        . sprintf("%010d", $offset3) . " 00000 n \n"
        . sprintf("%010d", $offset4) . " 00000 n \n"
        . sprintf("%010d", $offset5) . " 00000 n \n"
        . sprintf("%010d", $offset6) . " 00000 n \n";

    $trailer = "trailer\n<< /Size 7 /Root 1 0 R >>\nstartxref\n{$xrefOffset}\n%%EOF\n";

    return $header . $body . $xref . $trailer;
}

function pdfString(string $text): string
{
    // Escape special PDF characters
    $text = str_replace(['\\', '(', ')', "\r", "\n"], ['\\\\', '\\(', '\\)', '', ''], $text);
    return "({$text})";
}
