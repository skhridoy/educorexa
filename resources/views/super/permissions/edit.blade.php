@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.permissions.index') }}">Permissions</a></li>
        <li><span>/</span></li>
        <li class="active">Edit Permission</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-pen-to-square me-2" style="color:#4f46e5;"></i> Edit Permission</h2>
            <p class="edu-page-sub">Update the permission name or reassign it to a different module group.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="edu-panel">
                <div class="edu-panel-hd">
                    <h6 class="edu-panel-ttl">Permission Details</h6>
                </div>
                <div class="edu-panel-bd">
                    <form action="{{ route('super.permissions.update', $permission->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label class="edu-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control edu-input @error('name') is-invalid @enderror" value="{{ old('name', $permission->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="edu-label">Group Name (Module) <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-2 mb-3" style="max-height:100px; overflow-y:auto; padding:10px; background:#f8fafc; border-radius:12px; border:1px solid #f1f5f9;">
                                @foreach($groups as $group)
                                    <span class="badge {{ $permission->group_name == $group ? 'badge-indigo' : 'badge-light' }} cursor-pointer" style="padding:4px 10px; font-size:0.7rem; cursor:pointer;" onclick="document.getElementById('groupNameId').value = '{{ $group }}'">
                                        {{ $group }}
                                    </span>
                                @endforeach
                            </div>
                            <input list="groupOptions" name="group_name" id="groupNameId" class="form-control edu-input @error('group_name') is-invalid @enderror" value="{{ old('group_name', $permission->group_name) }}" required>
                            <datalist id="groupOptions">
                                @foreach($groups as $group) <option value="{{ $group }}"> @endforeach
                            </datalist>
                            @error('group_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('super.permissions.index') }}" class="btn-edu btn-edu-light">Cancel</a>
                            <button type="submit" class="btn-edu btn-edu-primary" style="padding:10px 30px;">
                                <i data-feather="refresh-cw" style="width:16px; margin-right:5px;"></i> Update Permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div style="background:#fff9f0; border-radius:20px; padding:30px; border:1px solid #ffedd5; height:100%;">
                <div style="width:50px; height:50px; border-radius:12px; background:#fff; display:flex; align-items:center; justify-content:center; color:#f59e0b; margin-bottom:20px; border:1px solid #ffedd5;">
                    <i data-feather="alert-triangle" style="width:24px;"></i>
                </div>
                <h5 style="font-family:'Outfit',sans-serif; font-weight:700; color:#9a3412; margin-bottom:15px;">Safety Warning</h5>
                <p style="color:#c2410c; font-size:0.875rem; line-height:1.6; margin-bottom:20px;">
                    Renaming a permission may break existing access checks in the code. Ensure all <code>@can</code> or <code>->can()</code> calls in your templates and controllers are updated to match the new name.
                </p>
                <div style="background:#fff; border-radius:12px; padding:15px; border:1px solid #ffedd5; font-size:0.8rem; color:#9a3412;">
                    <strong>Original:</strong> <code>{{ $permission->name }}</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection