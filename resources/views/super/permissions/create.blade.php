@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.permissions.index') }}">Permissions</a></li>
        <li><span>/</span></li>
        <li class="active">Create Permission</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-key me-2" style="color:#4f46e5;"></i> New Permission Token</h2>
            <p class="edu-page-sub">Define a new granular permission and assign it to a module group.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="edu-panel">
                <div class="edu-panel-hd">
                    <h6 class="edu-panel-ttl">Permission Details</h6>
                </div>
                <div class="edu-panel-bd">
                    <form action="{{ route('super.permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="edu-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control edu-input @error('name') is-invalid @enderror" placeholder="e.g. employee-create" value="{{ old('name') }}" required autofocus>
                            <small class="text-muted mt-2 d-block">Recommended format: <code>module-action</code> or <code>module.action</code></small>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="edu-label">Group Name (Module) <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-2 mb-3" style="max-height:100px; overflow-y:auto; padding:10px; background:#f8fafc; border-radius:12px; border:1px solid #f1f5f9;">
                                @foreach($groups as $group)
                                    <span class="badge-indigo cursor-pointer" style="padding:4px 10px; font-size:0.7rem; cursor:pointer;" onclick="document.getElementById('groupNameId').value = '{{ $group }}'">
                                        {{ $group }}
                                    </span>
                                @endforeach
                            </div>
                            <input list="groupOptions" name="group_name" id="groupNameId" class="form-control edu-input @error('group_name') is-invalid @enderror" placeholder="Select from above or type new..." value="{{ old('group_name') }}" required>
                            @error('group_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('super.permissions.index') }}" class="btn-edu btn-edu-light">Cancel</a>
                            <button type="submit" class="btn-edu btn-edu-primary" style="padding:10px 30px;">
                                <i data-feather="plus-circle" style="width:16px; margin-right:5px;"></i> Create Permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div style="background:#eef2ff; border-radius:20px; padding:30px; border:1px solid #e0e7ff; height:100%;">
                <div style="width:50px; height:50px; border-radius:12px; background:#fff; display:flex; align-items:center; justify-content:center; color:#4f46e5; margin-bottom:20px;">
                    <i data-feather="info" style="width:24px;"></i>
                </div>
                <h5 style="font-family:'Outfit',sans-serif; font-weight:700; color:#1e293b; margin-bottom:15px;">System Permissions</h5>
                <p style="color:#475569; font-size:0.875rem; line-height:1.6; margin-bottom:20px;">
                    Permissions are the foundation of your role-based access control (RBAC). 
                </p>
                <ul style="padding-left:20px; color:#475569; font-size:0.85rem; line-height:2;">
                    <li><strong>Naming:</strong> Use lowercase and dashes/dots for consistency.</li>
                    <li><strong>Grouping:</strong> Grouping helps organize permissions in the role editor.</li>
                    <li><strong>Access:</strong> Once created, you must assign this permission to a role for it to take effect.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection