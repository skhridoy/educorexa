@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Force table layout on mobile instead of card layout */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
            }
            .data-table-card .data-table thead {
                display: table-header-group !important;
            }
            .data-table-card .data-table thead th {
                white-space: nowrap;
                font-size: 0.74rem !important;
                padding: 9px 10px !important;
            }
            .data-table-card .data-table tbody {
                display: table-row-group !important;
            }
            .data-table-card .data-table tbody tr {
                display: table-row !important;
                padding: 0 !important;
                border-bottom: 1px solid #f1f5f9 !important;
            }
            .data-table-card .data-table tbody td {
                display: table-cell !important;
                padding: 9px 10px !important;
                text-align: left !important;
                white-space: nowrap !important;
                border-bottom: 1px solid #f1f5f9 !important;
                font-size: 0.84rem !important;
            }
            .data-table-card .data-table tbody td.text-center {
                text-align: center !important;
            }
            .data-table-card .data-table tbody td.text-end {
                text-align: right !important;
            }
            .data-table-card .data-table tbody td::before {
                display: none !important;
                content: none !important;
            }
        }

        /* ── Compact Mini Filter Underneath Title ── */
        .subject-mini-filter {
            display: flex;
            align-items: center;
            gap: 6px;
            width: 100%;
            background: #f8fafc;
            padding: 6px 8px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-top: 8px;
        }
        .mini-search-box {
            position: relative;
            flex: 1 1 auto;
            min-width: 120px;
        }
        .mini-search-box .search-ico {
            position: absolute;
            left: 9px;
            top: 50%;
            transform: translateY(-50%);
            color: #6366f1;
            font-size: 0.74rem;
            pointer-events: none;
        }
        .mini-input {
            height: 32px !important;
            padding-left: 26px !important;
            padding-right: 8px !important;
            font-size: 0.78rem !important;
            border-radius: 6px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #1e293b !important;
            box-shadow: none !important;
        }
        .mini-type-box {
            flex: 0 0 120px;
        }
        .mini-select {
            height: 32px !important;
            padding: 0 20px 0 8px !important;
            font-size: 0.78rem !important;
            border-radius: 6px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #1e293b !important;
            cursor: pointer;
            box-shadow: none !important;
        }
        .mini-input:focus,
        .mini-select:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.15) !important;
            background: #ffffff !important;
        }
        .mini-btn-box {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 0 0 auto;
        }
        .btn-mini-filter {
            height: 32px !important;
            padding: 0 12px !important;
            font-size: 0.76rem !important;
            font-weight: 700 !important;
            border-radius: 6px !important;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
            color: #ffffff !important;
            border: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 4px !important;
            white-space: nowrap !important;
            box-shadow: 0 1px 4px rgba(79,70,229,0.2) !important;
            transition: all 0.15s ease;
        }
        .btn-mini-filter:hover {
            opacity: 0.95;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .btn-mini-reset {
            height: 32px !important;
            width: 32px !important;
            min-width: 32px !important;
            padding: 0 !important;
            font-size: 0.74rem !important;
            border-radius: 6px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #64748b !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            transition: all 0.15s ease;
        }
        .btn-mini-reset:hover {
            background: #fee2e2 !important;
            border-color: #ef4444 !important;
            color: #ef4444 !important;
        }

        /* ── Responsive Mobile (< 576px) ── */
        @media (max-width: 575.98px) {
            .subject-mini-filter {
                flex-wrap: wrap !important;
                gap: 5px !important;
                padding: 6px !important;
            }
            .mini-search-box {
                flex: 1 1 100% !important;
                width: 100% !important;
            }
            .mini-type-box {
                flex: 1 1 auto !important;
                min-width: 0 !important;
            }
            .mini-btn-box {
                flex: 0 0 auto !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-book-open me-2"></i> Subjects Management</h1>
                <p class="page-subtitle">Create and manage institutional subjects, course codes, and types.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Form Column --}}
            <div class="col-lg-4">
                <div class="form-card">
                    <h5 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-plus me-2"></i> Create Subject
                    </h5>
                    <form action="{{ route('subjects.store', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Mathematics, English" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold">Subject Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g., MATH101, ENG101">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">Subject Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="" selected>Select Type</option>
                                <option value="theory">Theory</option>
                                <option value="practical">Practical</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Optional notes..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold">
                            <i class="fa-solid fa-check me-1"></i> Create Subject
                        </button>
                    </form>
                </div>
            </div>

            {{-- Subjects List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header p-3 border-bottom">
                        {{-- Title Row: Left is Title, Right is Total Count --}}
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h6 class="table-title mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                                <i class="fa-solid fa-list-ul text-primary"></i> Subject List
                            </h6>
                            <span class="badge bg-primary-subtle text-primary border-0 px-2.5 py-1 fw-bold" style="border-radius: 6px; font-size: 0.76rem;">
                                Total: {{ $totalSubjectsCount ?? $subjects->total() }} Subjects
                            </span>
                        </div>

                        {{-- Compact Filter Form Underneath Title --}}
                        <form method="GET" action="{{ route('subjects.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="subject-mini-filter">
                            <div class="mini-search-box">
                                <i class="fa-solid fa-magnifying-glass search-ico"></i>
                                <input type="text" 
                                       name="search" 
                                       class="form-control form-control-sm mini-input" 
                                       placeholder="Search subject or code..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="mini-type-box">
                                <select name="type" class="form-select form-select-sm mini-select" onchange="this.form.submit()">
                                    <option value="">All Types</option>
                                    <option value="theory" {{ request('type') == 'theory' ? 'selected' : '' }}>Theory</option>
                                    <option value="practical" {{ request('type') == 'practical' ? 'selected' : '' }}>Practical</option>
                                </select>
                            </div>
                            <div class="mini-btn-box">
                                <button type="submit" class="btn btn-sm btn-mini-filter">
                                    <i class="fa-solid fa-filter"></i> Filter
                                </button>
                                @if(request()->hasAny(['search', 'type']))
                                    <a href="{{ route('subjects.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-mini-reset" title="Clear Filters">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-2.5 px-3">Subject</th>
                                    <th class="py-2.5 px-3 text-center">Code</th>
                                    <th class="py-2.5 px-3 text-center">Type</th>
                                    <th class="py-2.5 px-3">Description</th>
                                    <th class="py-2.5 px-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                <tr>
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.7rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <i class="fa-solid fa-book"></i>
                                            </div>
                                            <span class="fw-bold text-dark text-capitalize" style="font-size:0.86rem;">{{ $subject->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge bg-light text-primary border px-2 py-0.5" style="border-radius:6px; font-size:0.75rem;">
                                            {{ $subject->code ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center px-3">
                                        @if($subject->type == 'practical')
                                            <span class="badge-pending" style="text-transform:capitalize; font-size:0.75rem; padding: 3px 8px;">
                                                <i class="fa-solid fa-flask me-1"></i>Practical
                                            </span>
                                        @else
                                            <span class="badge-completed" style="text-transform:capitalize; font-size:0.75rem; padding: 3px 8px;">
                                                <i class="fa-solid fa-pen-nib me-1"></i>{{ $subject->type ?? 'Theory' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3">
                                        <small class="text-muted">{{ \Str::limit($subject->description, 28) ?: '—' }}</small>
                                    </td>
                                    <td class="px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('subjects.edit', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" class="btn btn-action btn-sm btn-outline-warning" title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('subjects.destroy', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" class="btn btn-action btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
                                        No subjects found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($subjects->hasPages())
                        <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="text-muted small">
                                Showing {{ $subjects->firstItem() ?? 0 }} to {{ $subjects->lastItem() ?? 0 }} of {{ $subjects->total() }} subjects
                            </div>
                            <div>
                                {{ $subjects->links() }}
                            </div>
                        </div>
                    @endif
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
            text: "Do you want to delete this subject?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#4f46e5',
        });
    @endif
    @if(session('success'))
        Swal.fire({
            icon: '{{ session('type', 'success') }}',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection