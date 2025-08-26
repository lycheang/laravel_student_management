{{-- resources/views/teachers/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Teachers List')

@section('content')
<div class="container py-4">
    <div class="table-container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Teachers List</h3>
                    <div>
                        <!-- ✅ Back to Dashboard -->
                        <a href="{{ route('dashboard') }}" class="btn btn-light me-2">
                            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
                        <!-- ✅ Add New Teacher -->
                        <a href="{{ route('teachers.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-1"></i> Add New Teacher
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- ✅ Search Form -->
                <div class="d-flex justify-content-between mb-3">
                    <form method="GET" action="{{ route('teachers.index') }}" class="d-flex w-50">
                        <input type="text" name="search" class="form-control me-2"
                               placeholder="Search by ID or Name..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($teachers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                            <tr>
                                <td><strong>#{{ $teacher->teacher_id }}</strong></td>
                                <td>
                                    <img class="teacher-img"
                                         src="{{ $teacher->image ? asset('storage/' . $teacher->image) : 'https://via.placeholder.com/60?text=No+Image' }}"
                                         alt="Teacher Image">
                                </td>
                                <td>{{ $teacher->teacher_name }}</td>
                                <td>{{ $teacher->teacher_email }}</td>
                                <td>{{ $teacher->phone }}</td>
                                <td>
                                    @if($teacher->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="{{ route('teachers.edit', $teacher->teacher_id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher->teacher_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $teacher->teacher_id }})">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of {{ $teachers->total() }} entries
                    </div>
                    <div>
                        <!-- ✅ Keep search query in pagination -->
                        {{ $teachers->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-chalkboard-teacher fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Teachers Found</h4>
                    <p class="text-muted">There are no teachers in the system yet.</p>
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Your First Teacher
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .teacher-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
    }
    .action-buttons {
        white-space: nowrap;
    }
    .table-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .card-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 1.5rem;
    }
    .btn-light {
        background-color: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
        color: white;
    }
    .btn-light:hover {
        background-color: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.4);
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Delete confirmation function for teachers
    function confirmDelete(teacherId) {
        Swal.fire({
            title: 'Delete Confirmation',
            text: 'Are you sure you want to delete this teacher? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Find the form and submit it
                document.querySelector(`form[action="{{ url('teachers') }}/${teacherId}"]`).submit();
            }
        });
    }
</script>
@endpush