@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Permissions Management</h6>
                        <a href="{{ route('super.permissions.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="plus-square"></i>
                            Create Permission
                        </a>
                    </div>

                    {{-- সেশন মেসেজ --}}
                    @if(session('success'))
                        <div class="alert alert-fill-success alert-dismissible fade show" role="alert">
                            <i data-feather="check-circle" class="me-2 icon-sm"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3">ID</th>
                                    <th class="py-3">Permission Name</th>
                                    <th class="py-3">Guard</th>
                                    <th class="py-3 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                <tr>
                                    <td><span class="text-muted fw-bold">#{{ $permission->id }}</span></td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary px-3 text-lowercase">
                                            {{ str_replace('-', ' ', $permission->name) }}
                                        </span>
                                    </td>
                                    <td><code class="small text-muted">{{ $permission->guard_name ?? 'web' }}</code></td>
                                    <td class="text-end">
                                        {{-- Edit Icon Button --}}
                                        <a href="{{ route('super.permissions.edit', $permission->id) }}" 
                                           class="btn btn-xs btn-outline-info btn-icon me-1" 
                                           title="Edit Permission">
                                            <i data-feather="edit-3"></i>
                                        </a>
                                        
                                        {{-- Delete Icon Button --}}
                                        <form action="{{ route('super.permissions.destroy', $permission->id) }}" 
                                              method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-xs btn-outline-danger btn-icon delete-btn" title="Delete Permission">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Feather Icons Initialization
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Delete Confirmation with SweetAlert2
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                
                Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: "এই পারমিশনটি মুছে ফেললে সংশ্লিষ্ট রোলগুলোতে সমস্যা হতে পারে!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
                    cancelButtonText: 'বাতিল'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection