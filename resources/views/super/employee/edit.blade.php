@extends('layouts.main')

@section('customCSS')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title text-primary">Edit Employee: {{ $employee->name }}</h6>
                        <a href="{{ route('super.employees.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                    </div>
                    <hr>
                    <form action="{{ route('super.employees.update', $employee->id) }}" method="POST" id="editForm">
                        @csrf
                        
                        <div class="row">
                            {{-- User Basic Info --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email (Login ID) <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Password (Leave blank to keep current)</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••">
                            </div>

                            {{-- Employee Specific Info --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation" class="form-control" value="{{ $employee->employee->designation }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Personal Phone</label>
                                <input type="text" name="phone_personal" class="form-control" value="{{ $employee->employee->phone_personal }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Assign Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $employee->role == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Joining Date <span class="text-danger">*</span></label>
                                <input type="date" name="joining_date" class="form-control" value="{{ $employee->employee->joining_date }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Monthly Salary <span class="text-danger">*</span></label>
                                <input type="number" name="salary" class="form-control" value="{{ $employee->employee->salary }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $employee->employee->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $employee->employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Present Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ $employee->employee->address }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <button type="submit" class="btn btn-success w-100">
                                <i data-feather="check-circle" class="icon-sm me-1"></i> Update Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // সাকসেস বা এরর মেসেজ দেখানোর জন্য
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
    @endif
</script>
@endsection