@extends('layouts.appp')

@section('title', 'Dashboard')

@section('dashboard-active', 'active')

@section('styles')
    <style>
        .dashboard-card { border-radius: 10px; border: none; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .dashboard-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); }
        .card-student { background: linear-gradient(45deg, var(--primary), var(--info)); color: white; }
        .card-teacher { background: linear-gradient(45deg, var(--success), var(--secondary)); color: white; }
        .card-subject { background: linear-gradient(45deg, var(--warning), var(--danger)); color: white; }
        .card-attendance { background: linear-gradient(45deg, #7209b7, #3a0ca3); color: white; }
        .stat-number { font-size: 2.5rem; font-weight: bold; }
        .welcome-card { background: linear-gradient(to right, #4361ee, #3a0ca3); color: white; border-radius: 10px; }
    </style>
@endsection

@section('content')
    <!-- Welcome Card -->
    <div class="welcome-card p-4 mb-4">
        <div class="row">
            <div class="col-md-8">
                <h2>Welcome to Student Management System, {{ Auth::user()->name ?? 'Admin' }}!</h2>
                <p class="mb-0">Manage students, teachers, subjects, and attendance records with ease.</p>
            </div>
            <div class="col-md-4 text-end"><i class="fas fa-graduation-cap fa-4x opacity-50"></i></div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card dashboard-card card-student text-center p-3">
                <div class="card-body">
                    <i class="fas fa-user-graduate fa-3x mb-3"></i>
                    <h5>Students</h5>
                    <div class="stat-number">{{ $studentsCount }}</div>
                    <a href="/students" class="btn btn-light btn-sm mt-2">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card card-teacher text-center p-3">
                <div class="card-body">
                    <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                    <h5>Teachers</h5>
                    <div class="stat-number">{{ $teachersCount }}</div>
                    <a href="/teachers" class="btn btn-light btn-sm mt-2">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card card-subject text-center p-3">
                <div class="card-body">
                    <i class="fas fa-book fa-3x mb-3"></i>
                    <h5>Subjects</h5>
                    <div class="stat-number">{{ $subjectsCount }}</div>
                    <a href="/subjects" class="btn btn-light btn-sm mt-2">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card card-attendance text-center p-3">
                <div class="card-body">
                    <i class="fas fa-clipboard-check fa-3x mb-3"></i>
                    <h5>Attendance</h5>
                    <div class="stat-number">{{ $attendancePercentage }}%</div>
                    <a href="/attendances" class="btn btn-light btn-sm mt-2">View Records</a>
                </div>
            </div>
        </div>
    </div>
@endsection