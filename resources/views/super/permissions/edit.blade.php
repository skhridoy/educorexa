@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super.permissions.index') }}">Permissions</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0 text-warning fw-bold">EDIT PERMISSION</h6>
                        <a href="{{ route('super.permissions.index') }}" class="btn btn-sm btn-outline-secondary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="arrow-left"></i> Back
                        </a>
                    </div>
                    <hr class="mb-4">

                    <form action="{{ route('super.permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Permission Name --}}
                        <div class="mb-4">
                            <label for="permissionNameId" class="form-label fw-bold">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   id="permissionNameId" placeholder="e.g. student-edit" 
                                   value="{{ old('name', $permission->name) }}" autofocus
                                   style="padding: 10px; border-radius: 8px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Group Name Selection --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <label for="groupNameId" class="form-label fw-bold mb-0">Group Name (Module) <span class="text-danger">*</span></label>
                                <span class="text-muted small">Existing Modules:</span>
                            </div>

                            <div class="mb-2 d-flex flex-wrap gap-1" style="max-height: 80px; overflow-y: auto; padding: 5px; border: 1px dashed #e8ebf1; border-radius: 8px; background: #fcfcfd;">
                                @forelse($groups as $group)
                                    <span class="badge {{ $permission->group_name == $group ? 'bg-primary text-white' : 'bg-soft-primary text-primary' }} border cursor-pointer group-tag" 
                                          onclick="document.getElementById('groupNameId').value = '{{ $group }}'"
                                          style="cursor: pointer; font-weight: 500;">
                                        {{ $group }}
                                    </span>
                                @empty
                                    <small class="text-muted ps-1">No groups found</small>
                                @endforelse
                            </div>

                            <input list="groupOptions" name="group_name" id="groupNameId" 
                                   class="form-control @error('group_name') is-invalid @enderror" 
                                   placeholder="Select from above or type new..." 
                                   value="{{ old('group_name', $permission->group_name) }}"
                                   style="padding: 10px; border-radius: 8px;">
                            
                            <datalist id="groupOptions">
                                @foreach($groups as $group)
                                    <option value="{{ $group }}">
                                @endforeach
                            </datalist>

                            @error('group_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4 pt-2 text-end">
                            <a href="{{ route('super.permissions.index') }}" class="btn btn-light px-4 py-2 me-2">Cancel</a>
                            <button type="submit" class="btn btn-warning text-white px-4 py-2 shadow-sm">
                                <i data-feather="refresh-cw" class="icon-sm me-1"></i> Update Permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card border-0 shadow-sm border-start border-warning border-4" style="background-color: #fff9f0; border-radius: 15px;">
                <div class="card-body">
                    <h6 class="card-title d-flex align-items-center text-warning fw-bold">
                        <i data-feather="alert-triangle" class="me-2"></i> ATTENTION
                    </h6>
                    <hr>
                    <p class="text-muted small" style="line-height: 1.6;">
                        আপনি যদি নাম পরিবর্তন করেন, তবে আপনার কোডবেসে যেখানে এই পারমিশনটি চেক করা হয়েছে সেখানেও নাম আপডেট করতে হবে।
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: rgba(101, 113, 255, 0.1); }
    .group-tag:hover { background-color: #6571ff !important; color: white !important; transition: 0.3s; }
</style>
@endsection