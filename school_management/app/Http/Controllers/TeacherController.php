<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index(Request $request)
    {
        $query = Teacher::query();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('teacher_id', $search) // search exact ID
              ->orWhere('teacher_name', 'LIKE', "%{$search}%"); // search by name
    }

    $teachers = $query->paginate(10); // paginate results

    return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_name'     => 'required|string|max:100',
            'teacher_email'    => 'required|email|unique:teachers,teacher_email',
            'teacher_password' => 'required|string|min:6|max:100',
            'phone'            => 'required|string|max:20',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'        => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle image upload
        $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = date('Y-m-d-His') . '.' . $file->getClientOriginalExtension();
                $imagePath = Storage::disk('public')->putFileAs('teachers', $file, $filename);
            }

        $teacher = Teacher::create([
            'teacher_name'     => $request->teacher_name,
            'teacher_email'    => $request->teacher_email,
            'teacher_password' => bcrypt($request->teacher_password),
            'phone'            => $request->phone,
            'image'            => $imagePath,
            'is_active'        => $request->input('is_active', true),
        ]);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified teacher.
     */
    public function show(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'teacher_name'     => 'sometimes|string|max:100',
            'teacher_email'    => 'sometimes|email|unique:teachers,teacher_email,' . $id . ',teacher_id',
            'teacher_password' => 'sometimes|string|min:6|max:100',
            'phone'            => 'sometimes|string|max:20',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'        => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'teacher_name' => $request->teacher_name ?? $teacher->teacher_name,
            'teacher_email' => $request->teacher_email ?? $teacher->teacher_email,
            'phone' => $request->phone ?? $teacher->phone,
            'is_active' => $request->has('is_active') ? $request->is_active : $teacher->is_active,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
    // No longer deleting the old image
    $file = $request->file('image');
    $filename = date('Y-m-d') . '.' . $file->getClientOriginalExtension();
    $imagePath = Storage::disk('public')->putFileAs('teachers', $file, $filename);
    $updateData['image'] = $imagePath;
}

        // Update password only if provided
        if ($request->filled('teacher_password')) {
            $updateData['teacher_password'] = bcrypt($request->teacher_password);
        }

        $teacher->update($updateData);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        // Delete image if exists
        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}