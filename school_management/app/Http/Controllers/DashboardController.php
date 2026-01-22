<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
{
    $studentsCount = Student::count();
    $teachersCount = Teacher::count();
    $subjectsCount = Subject::count();

    $totalAttendance = Attendance::count();
    $presentAttendance = Attendance::where('status', 'Present')->count();
    $attendancePercentage = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100) : 0;

    $recentStudents = Student::latest()->take(5)->get();
    $recentAttendances = Attendance::with(['student', 'subject'])->latest()->take(6)->get();

    return view('dashboard', compact(
        'studentsCount',
        'teachersCount',
        'subjectsCount',
        'attendancePercentage',
        'recentStudents',
        'recentAttendances'
    ));
}

}
