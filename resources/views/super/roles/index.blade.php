@extends('layouts.main')

@section('customCSS')
<style>
    /* পারমিশন ব্যাজগুলোকে সুন্দরভাবে সাজানো */
    .permissions-container {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        max-width: 400px; /* টেবিলের কলাম উইডথ কন্ট্রোল করার জন্য */
    }
    .badge-perm {
        font-size: 11px;
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Roles & Permissions</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title mb-0">User Roles</h6>
                        <a href="{{ route('super.roles.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                            Create Role
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-fill-success alert-dismissible fade show" role="alert">
                            <i data-feather="check-circle" class="me-2 icon-sm"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3" style="width: 20%;">Role Name</th>
                                    <th class="py-3" style="width: 65%;">Assigned Permissions</th>
                                    <th class="py-3 text-end" style="width: 15%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-dark">{{ ucfirst($role->name) }}</span>
                                    </td>
                                    <td>
                                        <div class="permissions-container">
                                            @forelse($role->permissions as $perm)
                                                <span class="badge bg-soft-info text-info badge-perm border border-info">
                                                    {{ str_replace('-', ' ', $perm->name) }}
                                                </span>
                                            @empty
                                                <span class="text-muted small italic">No permissions assigned</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end">
                                            {{-- Edit Icon Button --}}
                                            <a href="{{ route('super.roles.edit', $role->id) }}" 
                                               class="btn btn-xs btn-outline-info btn-icon me-2" 
                                               title="Edit Role">
                                                <i data-feather="edit-2"></i>
                                            </a>

                                            {{-- Delete Icon Button --}}
                                            <form action="{{ route('super.roles.destroy', $role->id) }}" 
                                                  method="POST" 
                                                  class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-xs btn-outline-danger btn-icon delete-btn" title="Delete Role">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
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
                    text: "এই রোলটি মুছে ফেললে সংশ্লিষ্ট ইউজাররা লগইন করতে সমস্যায় পড়তে পারেন!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'হ্যাঁ, মুছে ফেলুন!',
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