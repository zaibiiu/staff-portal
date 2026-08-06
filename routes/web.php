<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/attendance/mark', [AttendanceController::class, 'markAttendance']);
});
