@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-primary">New Employee Registration</h6>
                    <hr>
                    <form action="{{ route('super.employees.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- User Basic Info --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email (Login ID) <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            {{-- Employee Specific Info --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation" class="form-control" placeholder="Accountant" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Personal Phone</label>
                                <input type="text" name="phone_personal" class="form-control" placeholder="017xxxxxxxx">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Assign Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Joining Date <span class="text-danger">*</span></label>
                                <input type="date" name="joining_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Monthly Salary <span class="text-danger">*</span></label>
                                <input type="number" name="salary" class="form-control" placeholder="25000" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Present Address</label>
                                <textarea name="address" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i data-feather="user-plus" class="icon-sm me-1"></i> Register Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection