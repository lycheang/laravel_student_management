@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
<div class="container py-4">
    <div class="table-container">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-edit me-2"></i>Edit Student</h1>
                <a href="{{ route('students.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-1"></i> Back to Students List
                </a>
            </div>
        </div>
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.update', $student->student_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="student_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('student_name') is-invalid @enderror"
                               id="student_name" name="student_name"
                               value="{{ old('student_name', $student->student_name) }}">
                        @error('student_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="student_email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('student_email') is-invalid @enderror"
                               id="student_email" name="student_email"
                               value="{{ old('student_email', $student->student_email) }}">
                        @error('student_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="student_password" class="form-label">Password (leave blank to keep current)</label>
                        <input type="password" class="form-control @error('student_password') is-invalid @enderror"
                               id="student_password" name="student_password" placeholder="Enter new password">
                        @error('student_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone"
                               value="{{ old('phone', $student->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                            <option value="">Select Gender (Current: {{ $student->gender }})</option>
                            <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Date of Birth (Current: {{ $student->date_of_birth }})</label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                               id="date_of_birth" name="date_of_birth"
                               value="{{ old('date_of_birth', $student->date_of_birth) }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="major" class="form-label">Major</label>
                        <input type="text" class="form-control @error('major') is-invalid @enderror"
                               id="major" name="major"
                               value="{{ old('major', $student->major) }}">
                        @error('major')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="enrollment_date" class="form-label">Enrollment Date (Current: {{ $student->enrollment_date }})</label>
                        <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror"
                               id="enrollment_date" name="enrollment_date"
                               value="{{ old('enrollment_date', $student->enrollment_date) }}">
                        @error('enrollment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="graduation_date" class="form-label">Graduation Date (Current: {{ $student->graduation_date ?? 'Not set' }})</label>
                        <input type="date" class="form-control @error('graduation_date') is-invalid @enderror"
                               id="graduation_date" name="graduation_date"
                               value="{{ old('graduation_date', $student->graduation_date) }}">
                        @error('graduation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($student->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $student->image) }}" alt="Current Image" width="80" class="img-thumbnail">
                                <small class="text-muted">Current image</small>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror"
                              id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $student->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active Student</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_graduate" name="is_graduate" value="1"
                                {{ old('is_graduate', $student->is_graduate) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_graduate">Graduated</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Student</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-container { background: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); overflow: hidden; }
    .page-header { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 20px; border-radius: 10px 10px 0 0; margin-bottom: 0; }
    .student-img-preview { width: 150px; height: 150px; object-fit: cover; }
    .form-check-input:checked { background-color: #4e73df; border-color: #4e73df; }
</style>
@endpush

@push('scripts')
<script>
    // Set max date for date of birth to today
    document.getElementById('date_of_birth').max = new Date().toISOString().split('T')[0];
    
    // Handle graduation status logic
    const isGraduateCheckbox = document.getElementById('is_graduate');
    const isActiveCheckbox = document.getElementById('is_active');
    const graduationDateInput = document.getElementById('graduation_date');
    
    isGraduateCheckbox.addEventListener('change', function() {
        if (this.checked) {
            // If marking as graduated, uncheck active status
            isActiveCheckbox.checked = false;
            
            // If graduation date is empty, set it to today
            if (!graduationDateInput.value) {
                graduationDateInput.value = new Date().toISOString().split('T')[0];
            }
        }
    });
    
    isActiveCheckbox.addEventListener('change', function() {
        if (this.checked && isGraduateCheckbox.checked) {
            // If making active but currently graduated, ask for confirmation
            if (confirm('This student is marked as graduated. Do you want to mark them as active again?')) {
                isGraduateCheckbox.checked = false;
            } else {
                this.checked = false;
            }
        }
    });
</script>
@endpush