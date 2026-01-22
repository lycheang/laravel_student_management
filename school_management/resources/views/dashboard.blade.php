@extends('layouts.appp')

@section('title', 'Dashboard')

@section('dashboard-active', 'active')

@section('styles')
    <style>
        :root {
            --card-radius: 15px;
            --transition-speed: 0.3s;
        }
        
        /* Stats Cards */
        .dashboard-card {
            border-radius: var(--card-radius);
            border: none;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
            overflow: hidden;
            position: relative;
            z-index: 1;
            height: 100%;
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            z-index: -1;
            opacity: 0;
            transition: opacity var(--transition-speed);
        }
        
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .dashboard-card:hover::before {
            opacity: 1;
        }

        .card-student { background: linear-gradient(135deg, #4361ee, #3a0ca3); color: white; }
        .card-teacher { background: linear-gradient(135deg, #4cc9f0, #4895ef); color: white; }
        .card-subject { background: linear-gradient(135deg, #f72585, #b5179e); color: white; }
        .card-attendance { background: linear-gradient(135deg, #ff9e00, #ff6d00); color: white; }

        .stat-icon {
            font-size: 3.5rem;
            opacity: 0.2;
            position: absolute;
            right: 20px;
            bottom: 20px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            z-index: 2;
        }
        
        .stat-label {
            font-size: 1.1rem;
            font-weight: 500;
            opacity: 0.9;
            z-index: 2;
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(to right, #2d3436, #000000); /* Elegant dark */
            background-image: url('https://img.freepik.com/free-vector/gradient-geometric-shape-background_23-2148424769.jpg'); /* Optional subtle pattern */
            background-size: cover;
            background-blend-mode: overlay;
            color: white;
            border-radius: var(--card-radius);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Tables & Lists */
        .content-card {
            background: white;
            border-radius: var(--card-radius);
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .card-header-custom {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.5rem;
        }

        .card-header-title {
            font-weight: 700;
            color: #2d3436;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .table-custom th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            color: #636e72;
            font-weight: 600;
            border-bottom: 2px solid #f1f2f6;
        }
        
        .table-custom td {
            vertical-align: middle;
            color: #2d3436;
            font-weight: 500;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f1f2f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #4361ee;
            margin-right: 15px;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-present { background-color: rgba(76, 201, 240, 0.1); color: #00b4d8; }
        .status-absent { background-color: rgba(247, 37, 133, 0.1); color: #f72585; }
        
        .student-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
            transition: background 0.2s;
        }
        
        .student-item:last-child { border-bottom: none; }
        .student-item:hover { background-color: #fafbfd; }
        
        .btn-view-all {
            background: rgba(67, 97, 238, 0.1);
            color: #4361ee;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-view-all:hover {
            background: #4361ee;
            color: white;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <!-- Welcome Card -->
    <div class="welcome-card p-5 mb-5 animate__animated animate__fadeIn">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold">Dashboard Overview</span>
                <h1 class="display-5 fw-bold mb-2">Hello, {{ Auth::user()->name ?? 'Admin' }}! 👋</h1>
                <p class="lead opacity-75 mb-4">Here's what's happening in your school today.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('students.create') }}" class="btn btn-light text-primary fw-bold px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-plus me-2"></i>New Student
                    </a>
                    <a href="{{ route('attendances.create') }}" class="btn btn-outline-light fw-bold px-4 py-2 rounded-pill">
                        <i class="fas fa-clipboard-check me-2"></i>Take Attendance
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="fas fa-school fa-8x opacity-25"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-5">
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card dashboard-card card-student p-4">
                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                    <div>
                        <div class="stat-number">{{ $studentsCount }}</div>
                        <div class="stat-label">Total Students</div>
                    </div>
                    <i class="fas fa-user-graduate stat-icon"></i>
                    <a href="{{ route('students.index') }}" class="text-white text-decoration-none mt-3 opacity-75 small">
                        View Details <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card dashboard-card card-teacher p-4">
                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                    <div>
                        <div class="stat-number">{{ $teachersCount }}</div>
                        <div class="stat-label">Total Teachers</div>
                    </div>
                    <i class="fas fa-chalkboard-teacher stat-icon"></i>
                    <a href="{{ route('teachers.index') }}" class="text-white text-decoration-none mt-3 opacity-75 small">
                        View Details <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card dashboard-card card-subject p-4">
                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                    <div>
                        <div class="stat-number">{{ $subjectsCount }}</div>
                        <div class="stat-label">Subjects</div>
                    </div>
                    <i class="fas fa-book stat-icon"></i>
                    <a href="{{ route('subjects.index') }}" class="text-white text-decoration-none mt-3 opacity-75 small">
                        View Details <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card card-attendance p-4">
                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                    <div>
                        <div class="stat-number">{{ $attendancePercentage }}%</div>
                        <div class="stat-label">Avg Attendance</div>
                    </div>
                    <i class="fas fa-chart-pie stat-icon"></i>
                    <a href="{{ route('attendances.index') }}" class="text-white text-decoration-none mt-3 opacity-75 small">
                        View Records <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row">
        <!-- Recent Attendance List -->
        <div class="col-lg-8 mb-4">
            <div class="card content-card h-100">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="card-header-title">
                        <i class="fas fa-clock text-primary me-2"></i> Recent Attendance
                    </h5>
                    <a href="{{ route('attendances.index') }}" class="btn-view-all">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Student</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAttendances as $attendance)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-light text-primary me-2" style="width:32px; height:32px; font-size: 0.8rem;">
                                                    {{ substr($attendance->student->student_name ?? 'U', 0, 1) }}
                                                </div>
                                                <span class="fw-bold text-dark">{{ $attendance->student->student_name ?? 'Unknown Student' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $attendance->subject->subject_name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') }}</td>
                                        <td>
                                            @if(strtolower($attendance->status) == 'present')
                                                <span class="status-badge status-present">Present</span>
                                            @else
                                                <span class="status-badge status-absent">Absent</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No recent attendance records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Students -->
        <div class="col-lg-4 mb-4">
            <div class="card content-card h-100">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="card-header-title">
                        <i class="fas fa-user-plus text-success me-2"></i> New Students
                    </h5>
                    <a href="{{ route('students.index') }}" class="btn-view-all small px-3">All</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentStudents as $student)
                            <div class="student-item">
                                <div class="avatar-circle">
                                    {{ substr($student->student_name, 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">{{ $student->student_name }}</h6>
                                    <small class="text-muted">{{ $student->major ?? 'General' }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light text-dark border">{{ $student->student_id }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">No students found.</div>
                        @endforelse
                    </div>
                    
                    <div class="p-3 bg-light rounded-bottom text-center">
                        <a href="{{ route('students.create') }}" class="text-decoration-none fw-bold" style="font-size: 0.9rem;">
                            <i class="fas fa-plus-circle me-1"></i> Register New Student
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection