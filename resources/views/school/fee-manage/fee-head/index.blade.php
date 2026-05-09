@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .fee-type-badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .type-monthly { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .type-once { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .type-recurring { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    </style>
@endsection

@section('content')
    <div class="page-content">
        {{-- Modern Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1" style="font-family:'Outfit', sans-serif;">Fee Management</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('school.dashboard', ['tenant' => auth()->user()->school->slug]) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Fee Heads</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row g-4">
            {{-- Create Fee Head Form --}}
            <div class="col-md-4">
                <div class="schools-panel h-100">
                    <div class="panel-header">
                        <h6 class="panel-title mb-0">Create Fee Head</h6>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('fee-heads.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-600">Fee Head Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Admission Fee" required>
                                <small class="text-muted">Give a clear name for the fee category.</small>
                            </div>
                            <div class="mb-4">
                                <label for="type" class="form-label fw-600">Billing Type</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="" disabled selected>Select billing frequency</option>
                                    <option value="monthly">Monthly (Every Month)</option>
                                    <option value="once">Once (One-time payment)</option>
                                    <option value="recurring">Recurring (Periodic)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                <i class="fa-solid fa-plus me-2"></i> Create Head
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Fee Heads List Table --}}
            <div class="col-md-8">
                <div class="schools-panel h-100">
                    <div class="panel-header d-flex justify-content-between align-items-center">
                        <h6 class="panel-title mb-0">Defined Fee Heads</h6>
                        <span class="badge bg-soft-primary text-primary">{{ $feeHeads->count() }} Total</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Name</th>
                                    <th>Billing Type</th>
                                    <th class="text-center pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeHeads as $feeHead)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $feeHead->name }}</div>
                                    </td>
                                    <td>
                                        <span class="fee-type-badge type-{{ $feeHead->type }}">
                                            {{ ucfirst($feeHead->type) }}
                                        </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('fee-heads.edit', ['tenant' => auth()->user()->school->slug, 'fee_head' => $feeHead->id]) }}"
                                               class="btn-icon-custom btn-action-edit" title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('fee-heads.destroy', ['tenant' => auth()->user()->school->slug, 'fee_head' => $feeHead->id]) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)"
                                                        class="btn-icon-custom btn-action-delete" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        No fee heads defined yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the fee head and may affect related settings!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif
    
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}'
    });
    @endif
</script>
@endsection