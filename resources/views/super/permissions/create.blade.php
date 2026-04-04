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
        <div class="col-md-6 grid-margin stretch-card"> {{-- কলাম সাইজ ৬ রাখা হয়েছে যাতে ফর্মটি দেখতে সুন্দর লাগে --}}
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Add New Permission</h6>
                        <a href="{{ route('super.permissions.index') }}" class="btn btn-sm btn-outline-secondary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="arrow-left"></i>
                            Back
                        </a>
                    </div>
                    <hr>

                    @if(session('success'))
                        <div class="alert alert-fill-success alert-dismissible fade show" role="alert">
                            <i data-feather="check-circle" class="me-2 icon-sm"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('super.permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="permissionNameId" class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="permissionNameId" 
                                   placeholder="e.g. user-create, student-edit"
                                   value="{{ old('name') }}"
                                   autofocus>
                            
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted mt-1 d-block">Use hyphen (-) instead of space (e.g., student-view)</small>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i data-feather="plus-circle" class="icon-sm me-1"></i>
                                Create Permission
                            </button>
                            <a href="{{ route('super.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        {{-- সাইডে একটি ছোট টিপস বক্স (ঐচ্ছিক) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="card-title d-flex align-items-center">
                        <i data-feather="info" class="text-info me-2"></i> Quick Tip
                    </h6>
                    <p class="text-muted small">
                        পারমিশনের নামগুলো সবসময় ইউনিক হতে হবে। সাধারণত মডিউল অনুযায়ী নাম রাখলে ম্যানেজ করা সহজ হয়। যেমন: 
                        <br><code>school-add</code>, <code>school-edit</code>, <code>school-delete</code>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endsection