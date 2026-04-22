@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super.permissions.index') }}">Permissions</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Permission</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Add New Permission</h6>
                        <a href="{{ route('super.permissions.index') }}" class="btn btn-sm btn-outline-secondary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="arrow-left"></i> Back
                        </a>
                    </div>
                    <hr>

                    <form action="{{ route('super.permissions.store') }}" method="POST">
                        @csrf
                        
                        {{-- Permission Name --}}
                        <div class="mb-3">
                            <label for="permissionNameId" class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   id="permissionNameId" placeholder="e.g. student-edit" value="{{ old('name') }}" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Group Name (মডিউল সিলেকশন) --}}
                        <div class="mb-3">
                            <label for="groupNameId" class="form-label">Group Name (Module) <span class="text-danger">*</span></label>
                            <select name="group_name" class="form-select @error('group_name') is-invalid @enderror" id="groupNameId">
                                <option value="">Select Module Group</option>
                                <option value="Academic" {{ old('group_name') == 'Academic' ? 'selected' : '' }}>Academic</option>
                                <option value="Admission" {{ old('group_name') == 'Admission' ? 'selected' : '' }}>Admission</option>
                                <option value="Fees" {{ old('group_name') == 'Fees' ? 'selected' : '' }}>Fees Management</option>
                                <option value="Employee" {{ old('group_name') == 'Employee' ? 'selected' : '' }}>Employee</option>
                                <option value="Settings" {{ old('group_name') == 'Settings' ? 'selected' : '' }}>System Settings</option>
                                <option value="Custom" {{ old('group_name') == 'Custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                            @error('group_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-1 d-block">এটি নির্ধারণ করবে পারমিশনটি কোন মডিউলের আন্ডারে দেখাবে।</small>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i data-feather="plus-circle" class="icon-sm me-1"></i> Create Permission
                            </button>
                            <a href="{{ route('super.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="card-title d-flex align-items-center">
                        <i data-feather="info" class="text-info me-2"></i> Important Note
                    </h6>
                    <ul class="text-muted small ps-3">
                        <li class="mb-2"><strong>Naming Convention:</strong> চেষ্টা করবেন <code>module-action</code> ফরম্যাট ফলো করতে (যেমন: <code>user-delete</code>)।</li>
                        <li class="mb-2"><strong>Grouping:</strong> সঠিক গ্রুপ সিলেক্ট করলে রোল ক্রিয়েট করার সময় পারমিশনগুলো আলাদা বক্সে সাজানো থাকবে।</li>
                        <li><strong>Uniqueness:</strong> একটি নাম একবারই ব্যবহার করা যাবে।</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection