<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display all attendance records.
     */
    
    public function index(Request $request)
{
    $selectedDate = $request->get('date', date('Y-m-d'));
    $selectedSubject = $request->get('subject_id');
    $selectedStatus = $request->get('status');
    
    // Get total count of all active students (not paginated)
    $totalStudents = Student::where('is_active', true)->count();
    
    // Get students with their attendance for the selected date and subject
    $query = Student::where('is_active', true)
        ->with(['attendances' => function($query) use ($selectedDate, $selectedSubject) {
            $query->where('attendance_date', $selectedDate);
            if ($selectedSubject) {
                $query->where('subject_id', $selectedSubject);
            }
        }]);
    
    // Apply status filter if provided
    if ($selectedStatus) {
        $query->whereHas('attendances', function($query) use ($selectedDate, $selectedSubject, $selectedStatus) {
            $query->where('attendance_date', $selectedDate);
            if ($selectedSubject) {
                $query->where('subject_id', $selectedSubject);
            }
            if ($selectedStatus !== 'no_record') {
                $query->where('status', $selectedStatus);
            } else {
                $query->whereNull('status'); // For no_record status
            }
        }, $selectedStatus === 'no_record' ? '=' : '>', 0);
    }
    
    $students = $query->paginate(10);
    
    // Count attendance statuses for ALL students (not just paginated ones)
    $presentCount = Attendance::where('attendance_date', $selectedDate)
        ->when($selectedSubject, function($query) use ($selectedSubject) {
            $query->where('subject_id', $selectedSubject);
        })
        ->where('status', 'present')
        ->count();
    
    $absentCount = Attendance::where('attendance_date', $selectedDate)
        ->when($selectedSubject, function($query) use ($selectedSubject) {
            $query->where('subject_id', $selectedSubject);
        })
        ->where('status', 'absent')
        ->count();
    
    $noRecordCount = $totalStudents - ($presentCount + $absentCount);
    
    // Get subjects that have attendance records for the selected date
    $subjects = Subject::whereHas('attendances', function($query) use ($selectedDate) {
        $query->where('attendance_date', $selectedDate);
    })->get();
    
    return view('attendances.index', compact(
        'students', 
        'subjects',
        'selectedDate',
        'selectedSubject',
        'selectedStatus',
        'presentCount',
        'absentCount',
        'noRecordCount',
        'totalStudents'
    ));
}

    /**
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        $students = Student::where('is_active', true)->get();
        $subjects = Subject::all();
        return view('attendances.create', compact('students', 'subjects'));
    }

    /**
     * Store a new attendance record.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id'      => 'required|exists:students,student_id',
            'subject_id'      => 'required|exists:subjects,subject_id',
            'attendance_date' => 'required|date',
            'status'          => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $validatedData = $validator->validated();
            
            // Convert status to lowercase and handle different values
            $status = strtolower(trim($validatedData['status']));
            
            // Map different status values to allowed values
            $statusMapping = [
                'late' => 'present',     // Convert 'late' to 'present'
                'lateness' => 'present', // Convert 'lateness' to 'present'
                'delay' => 'present',    // Convert 'delay' to 'present'
                'on time' => 'present',  // Convert 'on time' to 'present'
                'missing' => 'absent',   // Convert 'missing' to 'absent'
                'absentee' => 'absent',  // Convert 'absentee' to 'absent'
            ];
            
            // Use mapped value or original value
            $validatedData['status'] = $statusMapping[$status] ?? $status;
            
            // Validate against allowed values
            if (!in_array($validatedData['status'], ['present', 'absent'])) {
                return redirect()->back()
                    ->with('error', 'Status must be either Present or Absent. Received: ' . $request->status)
                    ->withInput();
            }
            
            Attendance::create($validatedData);
            
            return redirect()->route('attendances.index')
                ->with('success', 'Attendance recorded successfully');
                
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for duplicate entry
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return redirect()->back()
                    ->with('error', 'Duplicate entry: this student already has attendance for this subject on this date')
                    ->withInput();
            }
            
            // Check for data truncation error
            if (str_contains($e->getMessage(), 'Data truncated')) {
                return redirect()->back()
                    ->with('error', 'Invalid status value. Please use only "Present" or "Absent"')
                    ->withInput();
            }
            
            return redirect()->back()
                ->with('error', 'Database error: ' . $e->getMessage())
                ->withInput();
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display a specific attendance record.
     */
    public function show(string $id)
    {
        $attendance = Attendance::with(['student', 'subject'])->findOrFail($id);
        return view('attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing an attendance record.
     */
    public function edit(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $students = Student::where('is_active', true)->get();
        $subjects = Subject::all();
        return view('attendances.edit', compact('attendance', 'students', 'subjects'));
    }

    /**
     * Update an attendance record.
     */
    public function update(Request $request, string $id)
    {
        $attendance = Attendance::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'student_id'      => 'sometimes|exists:students,student_id',
            'subject_id'      => 'sometimes|exists:subjects,subject_id',
            'attendance_date' => 'sometimes|date',
            'status'          => 'sometimes',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $validatedData = $validator->validated();
            
            // Process status if provided
            if (isset($validatedData['status'])) {
                $status = strtolower(trim($validatedData['status']));
                
                // Map different status values to allowed values
                $statusMapping = [
                    'late' => 'present',
                    'lateness' => 'present',
                    'delay' => 'present',
                    'on time' => 'present',
                    'missing' => 'absent',
                    'absentee' => 'absent',
                ];
                
                $validatedData['status'] = $statusMapping[$status] ?? $status;
                
                // Validate against allowed values
                if (!in_array($validatedData['status'], ['present', 'absent'])) {
                    return redirect()->back()
                        ->with('error', 'Status must be either Present or Absent')
                        ->withInput();
                }
            }
            
            $attendance->update($validatedData);
            
            return redirect()->route('attendances.index')
                ->with('success', 'Attendance updated successfully');
                
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return redirect()->back()
                    ->with('error', 'Duplicate entry: this student already has attendance for this subject on this date')
                    ->withInput();
            }
            
            if (str_contains($e->getMessage(), 'Data truncated')) {
                return redirect()->back()
                    ->with('error', 'Invalid status value. Please use only "Present" or "Absent"')
                    ->withInput();
            }
            
            return redirect()->back()
                ->with('error', 'Database error: ' . $e->getMessage())
                ->withInput();
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete an attendance record.
     */
    public function destroy(string $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();

            return redirect()->route('attendances.index')
                ->with('success', 'Attendance deleted successfully');
                
        } catch (\Exception $e) {
            return redirect()->route('attendances.index')
                ->with('error', 'Error deleting attendance: ' . $e->getMessage());
        }
    }
}