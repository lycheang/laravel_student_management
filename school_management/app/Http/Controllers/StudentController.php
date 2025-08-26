<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Carbon\Carbon;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index()
    {
        try {
            $students = Student::paginate(10);
            return view('students.index', compact('students'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve students: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_name'     => 'required|string|max:100',
            'student_password' => 'required|string|min:6|max:100',
            'student_email'    => 'required|email|unique:students,student_email',
            'gender'           => 'required|string|in:Male,Female,Other',
            'address'          => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'date_of_birth'    => 'required|date',
            'major'            => 'required|string|max:100',
            'enrollment_date'  => 'required|date',
            'graduation_date'  => 'nullable|date|after_or_equal:enrollment_date',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'        => 'sometimes|boolean',
            'is_graduate'      => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Handle image upload with timestamp filename
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = date('Y-m-d-His') . '.' . $file->getClientOriginalExtension();
                $imagePath = Storage::disk('public')->putFileAs('students', $file, $filename);
            }

            // Calculate default graduation date if not provided (4 years after enrollment)
            $enrollmentDate = Carbon::parse($request->enrollment_date);
            $graduationDate = $request->graduation_date ?? $enrollmentDate->copy()->addYears(4);

            $student = Student::create([
                'student_name'     => $request->student_name,
                'student_password' => bcrypt($request->student_password),
                'student_email'    => $request->student_email,
                'gender'           => $request->gender,
                'address'          => $request->address,
                'phone'            => $request->phone,
                'date_of_birth'    => $request->date_of_birth,
                'major'            => $request->major,
                'is_active'        => $request->input('is_active', true),
                'is_graduate'      => $request->input('is_graduate', false),
                'enrollment_date'  => $request->enrollment_date,
                'graduation_date'  => $graduationDate,
                'image'            => $imagePath,
            ]);

            return redirect()->route('students.index')->with('success', 'Student created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to create student: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified student.
     */
    public function show(string $id)
    {
        try {
            $student = Student::findOrFail($id);
            return view('students.show', compact('student'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve student: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(string $id)
    {
        try {
            $student = Student::findOrFail($id);
            return view('students.edit', compact('student'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve student: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified student.
     * No need to input password, date of birth, or enrollment date again.
     */
    public function update(Request $request, string $id)
    {
        try {
            $student = Student::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'student_name'     => 'sometimes|string|max:100',
                'student_password' => 'sometimes|string|min:6|max:100',
                'student_email'    => 'sometimes|email|unique:students,student_email,' . $id . ',student_id',
                'gender'           => 'sometimes|string|in:Male,Female,Other',
                'address'          => 'sometimes|string|max:255',
                'phone'            => 'sometimes|string|max:20',
                'major'            => 'sometimes|string|max:100',
                'graduation_date'  => 'nullable|date|after_or_equal:enrollment_date',
                'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active'        => 'sometimes|boolean',
                'is_graduate'      => 'sometimes|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $updateData = [
                'student_name'  => $request->student_name ?? $student->student_name,
                'student_email' => $request->student_email ?? $student->student_email,
                'gender'        => $request->gender ?? $student->gender,
                'address'       => $request->address ?? $student->address,
                'phone'         => $request->phone ?? $student->phone,
                'major'         => $request->major ?? $student->major,
                'is_active'     => $request->has('is_active') ? $request->is_active : $student->is_active,
                'is_graduate'   => $request->has('is_graduate') ? $request->is_graduate : $student->is_graduate,
            ];

            // Update graduation date if explicitly provided
            if ($request->has('graduation_date')) {
                $updateData['graduation_date'] = $request->graduation_date;
            }

            // Handle image upload
            if ($request->hasFile('image')) {
    // No longer deleting the old image
    $file = $request->file('image');
    $filename = date('Y-m-d') . '.' . $file->getClientOriginalExtension();
    $imagePath = Storage::disk('public')->putFileAs('students', $file, $filename);
    $updateData['image'] = $imagePath;
}

            // Update password only if provided
            if ($request->filled('student_password')) {
                $updateData['student_password'] = bcrypt($request->student_password);
            }

            $student->update($updateData);

            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update student: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified student.
     */
    public function destroy(string $id)
    {
        try {
            $student = Student::findOrFail($id);

            if ($student->image && Storage::disk('public')->exists($student->image)) {
                Storage::disk('public')->delete($student->image);
            }

            $student->delete();

            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

    /**
     * Check graduation status for all students.
     */
    public function checkGraduationStatus()
    {
        $students = Student::where('is_graduate', false)->get();
        foreach ($students as $student) {
            $graduationDate = Carbon::parse($student->graduation_date);
            if ($graduationDate->isPast()) {
                $student->update([
                    'is_graduate' => true,
                    'is_active'  => false
                ]);
            }
        }
        return response()->json(['message' => 'Graduation status checked successfully']);
    }
}
