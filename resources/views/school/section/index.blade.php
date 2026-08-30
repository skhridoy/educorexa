@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-shapes me-2"></i> {{ __('Class Sections') }}</h1>
                <p class="page-subtitle">{{ __('Manage class sections (Section A, B, Rose, Sunshine, etc.).') }}</p>
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
                        <i class="fa-solid fa-plus me-2"></i> {{ __('Create Section') }}
                    </h5>
                    <form action="{{ route('sections.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">{{ __('Section Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. A, B, Science, Rose" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">{{ __('Description') }}</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="{{ __('Enter description (optional)') }}">
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold">
                            <i class="fa-solid fa-check me-1"></i> {{ __('Create Section') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Sections List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header d-flex align-items-center justify-content-between p-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-indigo-600"></i> {{ __('Sections List') }}</h5>
                        <span class="badge bg-light text-muted border px-3 py-1" style="border-radius:10px;">
                            {{ count($sections) }} {{ __('Sections') }}
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3"># {{ __('ID') }}</th>
                                    <th class="py-3 px-3">{{ __('Section Name') }}</th>
                                    <th class="py-3 px-3">{{ __('Description') }}</th>
                                    <th class="py-3 px-3 text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sections as $section)
                                <tr>
                                    <td class="px-3 fw-bold text-muted" style="font-size:0.8rem;">#{{ $section->id }}</td>
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-weight:700;font-size:0.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                {{ substr($section->name, 0, 1) }}
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size:0.88rem;">{{ __('Section') }} {{ $section->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3">
                                        <span class="text-muted" style="font-size:0.82rem;">{{ $section->description ?: '—' }}</span>
                                    </td>
                                    <td class="px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('sections.edit', ['tenant' => auth()->user()->school->slug,'section' => $section->id]) }}" class="btn btn-action btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('sections.destroy', ['tenant' => auth()->user()->school->slug,'section' => $section->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" class="btn btn-action btn-sm btn-outline-danger" title="{{ __('Delete') }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                        {{ __('No sections found.') }}
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
</div>
@endsection

@section('customJs')
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('Do you want to delete this section?') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: "{{ __('Yes, delete it!') }}",
            cancelButtonText: "{{ __('Cancel') }}"
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