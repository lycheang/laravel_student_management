@extends('layouts.app')

@section('title', 'Students List')

@section('content')
<div class="container py-4">
    <div class="table-container">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-user-graduate me-2"></i>Students List</h1>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-light me-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                    <a href="{{ route('students.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-1"></i> Add New Student
                    </a>
                </div>
            </div>
        </div>

        <div class="search-box">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="searchInput" class="form-label">Search by ID or Name</label>
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        <button class="btn btn-primary" type="button" id="searchButton">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">Filter by Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="all">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="graduateFilter" class="form-label">Filter by Graduation</label>
                    <select id="graduateFilter" class="form-select">
                        <option value="all">All</option>
                        <option value="graduated">Graduated</option>
                        <option value="not_graduated">Not Graduated</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-outline-secondary mt-auto" type="button" id="resetButton">
                        <i class="fas fa-times"></i> Reset Filters
                    </button>
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

            @if($students->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="studentsTable">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Major</th>
                            <th>Enrollment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr class="student-row" 
                            data-is-active="{{ $student->is_active ? 'active' : 'inactive' }}" 
                            data-is-graduate="{{ $student->is_graduate ? 'graduated' : 'not_graduated' }}">
                            <td><strong>#{{ $student->student_id }}</strong></td>
                            <td>
                                <img class="student-img" src="{{ $student->image ? asset('storage/' . $student->image) : 'https://via.placeholder.com/60?text=No+Image' }}" alt="Student Image">
                            </td>
                            <td class="student-name">{{ $student->student_name }}</td>
                            <td>{{ $student->student_email }}</td>
                            <td>
                                <span class="badge bg-{{ $student->gender == 'Male' ? 'primary' : 'info' }}">
                                    {{ $student->gender }}
                                </span>
                            </td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $student->major }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($student->enrollment_date)->format('M d, Y') }}</td>
                            <td>
                                @if($student->is_graduate)
                                    <span class="badge bg-success">Graduated</span>
                                @elseif($student->is_active)
                                    <span class="badge bg-primary">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="action-buttons">
                                <a href="{{ route('students.edit', $student->student_id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form id="delete-form-{{ $student->student_id }}" action="{{ route('students.destroy', $student->student_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $student->student_id }})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="no-results" id="noResults">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Students Found</h4>
                <p class="text-muted">No students match your search criteria.</p>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} entries
                </div>
                <div>
                    {{ $students->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-user-graduate fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No Students Found</h4>
                <p class="text-muted">There are no students in the system yet.</p>
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Your First Student
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .student-img { width: 60px; height: 60px; object-fit: cover; border-radius: 50%; }
    .action-buttons { white-space: nowrap; }
    .table-container { background: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); overflow: hidden; }
    .page-header { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 20px; border-radius: 10px 10px 0 0; margin-bottom: 0; }
    .search-box { background-color: #f8f9fa; padding: 20px; border-bottom: 1px solid #dee2e6; }
    .no-results { display: none; text-align: center; padding: 30px; }
</style>
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const resetButton = document.getElementById('resetButton');
        const statusFilter = document.getElementById('statusFilter');
        const graduateFilter = document.getElementById('graduateFilter');
        const studentRows = document.querySelectorAll('.student-row');
        const noResults = document.getElementById('noResults');
        const table = document.getElementById('studentsTable');
        const paginationInfo = document.querySelector('.text-muted');
        const paginationLinks = document.querySelector('.pagination');
        
        function filterStudents() {
            const searchText = searchInput.value.toLowerCase().trim();
            const selectedStatus = statusFilter.value;
            const selectedGraduate = graduateFilter.value;
            let visibleCount = 0;
            
            studentRows.forEach(row => {
                const id = row.querySelector('td:first-child strong').textContent.toLowerCase();
                const name = row.querySelector('.student-name').textContent.toLowerCase();
                const isActive = row.getAttribute('data-is-active');
                const isGraduate = row.getAttribute('data-is-graduate');
                
                // Check if the row matches all filter criteria
                const matchesSearch = id.includes(searchText) || name.includes(searchText);
                const matchesStatus = selectedStatus === 'all' || isActive === selectedStatus;
                const matchesGraduate = selectedGraduate === 'all' || isGraduate === selectedGraduate;

                if (matchesSearch && matchesStatus && matchesGraduate) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Toggle visibility of the "No Results" message
            if (visibleCount === 0) {
                noResults.style.display = 'block';
                table.style.display = 'none';
                paginationInfo.style.display = 'none';
                paginationLinks.style.display = 'none';
            } else {
                noResults.style.display = 'none';
                table.style.display = 'table';
                paginationInfo.style.display = 'block';
                paginationLinks.style.display = 'flex';
            }
        }
        
        searchButton.addEventListener('click', filterStudents);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                filterStudents();
            }
        });
        
        // Add event listeners for the new filter dropdowns
        statusFilter.addEventListener('change', filterStudents);
        graduateFilter.addEventListener('change', filterStudents);
        
        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = 'all';
            graduateFilter.value = 'all';
            filterStudents();
        });
    });
</script>
@endpush