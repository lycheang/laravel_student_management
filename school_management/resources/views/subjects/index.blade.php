{{-- resources/views/subjects/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Subjects List')

@section('content')
<div class="container py-4">
    <div class="table-container">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-book me-2"></i>Subjects List</h1>
                <div>
                    <!-- ✅ Back to Dashboard -->
                    <a href="{{ route('dashboard') }}" class="btn btn-light me-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                    <!-- ✅ Add New Subject -->
                    <a href="{{ route('subjects.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-1"></i> Add New Subject
                    </a>
                </div>
            </div>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($subjects->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Subject Name</th>
                            <th>Teacher</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                        <tr>
                            <td><strong>#{{ $subject->subject_id }}</strong></td>
                            <td>{{ $subject->subject_name }}</td>
                            <td>
                                @if($subject->teacher)
                                    {{ $subject->teacher->teacher_name }}
                                @else
                                    <span class="text-muted">No teacher assigned</span>
                                @endif
                            </td>
                            <td class="action-buttons">
                                <a href="{{ route('subjects.edit', $subject->subject_id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form id="delete-form-{{ $subject->subject_id }}" 
      action="{{ route('subjects.destroy', $subject->subject_id) }}" 
      method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-outline-danger" 
            onclick="confirmDelete({{ $subject->subject_id }})">
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
                    Showing {{ $subjects->firstItem() }} to {{ $subjects->lastItem() }} of {{ $subjects->total() }} entries
                </div>
                <div>
                    {{ $subjects->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No Subjects Found</h4>
                <p class="text-muted">There are no subjects in the system yet.</p>
                <a href="{{ route('subjects.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Your First Subject
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    overflow: hidden;
}
.page-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 20px;
    border-radius: 10px 10px 0 0;
    margin-bottom: 0;
}
.action-buttons {
    white-space: nowrap;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(itemId) {
    Swal.fire({
        title: 'Delete Confirmation',
        text: 'Are you sure you want to delete it?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + itemId).submit();
        }
    });
}
</script>
@endpush