<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        // Ensure user is staff
        if (!Auth::user()->isStaff()) {
            return response()->json([
                'success' => false,
                'message' => 'Only staff members can mark attendance'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'selfie' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB, specific formats
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if attendance already exists for today for this user only
        $existingAttendance = Attendance::where('user_id', Auth::id())
            ->where('date', now()->toDateString())
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already marked for today'
            ], 409); // 409 Conflict
        }

        try {
            // Store the selfie with secure filename
            $selfiePath = $request->file('selfie')->store('attendance-selfies', 'public');

            // Create attendance record - user_id is forced to authenticated user
            $attendance = Attendance::create([
                'user_id' => Auth::id(), // Cannot be overridden
                'date' => now()->toDateString(),
                'status' => 'present',
                'check_in' => now()->toTimeString(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'selfie' => $selfiePath,
                'selfie_taken_at' => now(),
                'attendance_source' => 'self',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Attendance marked successfully',
                'data' => $attendance
            ], 201);
        } catch (\Exception $e) {
            // Clean up uploaded file if database insert fails
            if (isset($selfiePath) && Storage::disk('public')->exists($selfiePath)) {
                Storage::disk('public')->delete($selfiePath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error saving attendance: ' . $e->getMessage()
            ], 500);
        }
    }
}
