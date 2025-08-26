@extends('layouts.app')

@section('title', 'Student Attendance Status')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Student Attendance Status</h3>
                <div>
                    <!-- ✅ Back to Dashboard -->
                    <a href="{{ route('dashboard') }}" class="btn btn-light me-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                    <a href="{{ route('attendances.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-1"></i> Add Attendance
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Display success/error messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Attendance Stats -->
            <div class="attendance-stats">
                <div class="stat-card">
                    <div class="stat-number present-stat">{{ $presentCount }}</div>
                    <div class="stat-label">Present</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number absent-stat">{{ $absentCount }}</div>
                    <div class="stat-label">Absent</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number no-record-stat">{{ $noRecordCount }}</div>
                    <div class="stat-label">No Record</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number total-stat">{{ $totalStudents }}</div>
                    <div class="stat-label">Total Students</div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <div class="filter-section">
                <form method="GET" action="{{ route('attendances.index') }}">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $selectedDate }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="subject_id" class="form-label">Subject</label>
                            <select class="form-select" id="subject_id" name="subject_id">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->subject_id }}" {{ $selectedSubject == $subject->subject_id ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="present" {{ $selectedStatus == 'present' ? 'selected' : '' }}>Present</option>
                                <option value="absent" {{ $selectedStatus == 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="no_record" {{ $selectedStatus == 'no_record' ? 'selected' : '' }}>No Record</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Apply Filters
                            </button>
                            <a href="{{ route('attendances.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-sync me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Attendance Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>ID</th>
                            <th>Major</th>
                            <th>Status</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                        @php
                            $attendance = $student->attendances->first();
                            $status = $attendance ? $attendance->status : 'no_record';
                            $subject = $attendance ? $attendance->subject : null;
                        @endphp
                        <tr class="{{ $status }}-row">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ $student->image ? asset('storage/' . $student->image) : 'https://via.placeholder.com/45?text=No+Image' }}" class="student-img me-2" alt="Student Image">
                                {{ $student->student_name }}
                            </td>
                            <td>#{{ $student->student_id }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $student->major }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $status == 'present' ? 'success' : ($status == 'absent' ? 'danger' : 'secondary') }} status-badge">
                                    {{ $status == 'present' ? 'Present' : ($status == 'absent' ? 'Absent' : 'No Record') }}
                                </span>
                            </td>
                            <td>
                                @if($subject)
                                    {{ $subject->subject_name }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                {{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->format('M d, Y') : 'Today' }}
                            </td>
                            <td>
                                @if($attendance)
                                    <a href="{{ route('attendances.edit', $attendance->attendance_id) }}" class="btn btn-sm btn-outline-primary action-btn">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <form action="{{ route('attendances.destroy', $attendance->attendance_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger action-btn" onclick="confirmDelete({{ $attendance->attendance_id }})">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('attendances.create') }}?student_id={{ $student->student_id }}&date={{ $selectedDate ?: date('Y-m-d') }}" class="btn btn-sm btn-outline-success action-btn">
                                        <i class="fas fa-plus"></i> Mark
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} entries
                </div>
                <div>
                    {{ $students->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simple filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('status');
        const rows = document.querySelectorAll('tbody tr');
        
        statusFilter.addEventListener('change', function() {
            const status = this.value;
            
            rows.forEach(row => {
                if (!status) {
                    row.style.display = '';
                } else if (row.classList.contains(status + '-row')) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Delete confirmation function
    function confirmDelete(attendanceId) {
        Swal.fire({
            title: 'Delete Confirmation',
            text: 'Are you sure you want to delete this attendance record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Find the form and submit it
                document.querySelector(`form[action="{{ url('attendances') }}/${attendanceId}"]`).submit();
            }
        });
    }
</script>
@endpush