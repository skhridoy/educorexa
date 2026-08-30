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
                <h1 class="page-title"><i class="fa-solid fa-graduation-cap me-2"></i> {{ __('Classes Management') }}</h1>
                <p class="page-subtitle">{{ __('Create, organize, and assign categories to school classes.') }}</p>
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
                    <h5 class="mb-4 fw-bold text-primary" id="form-title">
                        <i class="fa-solid fa-plus me-2"></i> {{ __('Create Class') }}
                    </h5>
                    <form id="class-form" action="{{ route('classes.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div id="method-field"></div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">{{ __('Class Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Class One, Grade 10" required>
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold">{{ __('Class Code') }}</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g., 101, A1">
                        </div>

                        <div class="mb-3">
                            <label for="school_category_id" class="form-label fw-semibold">{{ __('Category') }} <span class="text-danger">*</span></label>
                            <select id="school_category_id" name="school_category_id" class="form-select" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">{{ __('Description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="{{ __('Optional notes...') }}"></textarea>
                        </div>

                        <div class="d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-2 fw-bold" id="submit-btn">
                                <i class="fa-solid fa-check me-1"></i> {{ __('Create Class') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary d-none py-2 px-3" id="cancel-btn" onclick="resetForm()">
                                <i class="fa-solid fa-xmark me-1"></i> {{ __('Cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Classes List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header d-flex align-items-center justify-content-between p-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list-ul me-2 text-indigo-600"></i> {{ __('Classes List') }}</h5>
                        <span class="badge bg-light text-muted border px-3 py-1" style="border-radius:10px;">
                            {{ count($classes) }} {{ __('Classes') }}
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3">#</th>
                                    <th class="py-3 px-3">{{ __('Class Name') }}</th>
                                    <th class="py-3 px-3 text-center">{{ __('Code') }}</th>
                                    <th class="py-3 px-3 text-center">{{ __('Category') }}</th>
                                    <th class="py-3 px-3">{{ __('Description') }}</th>
                                    <th class="py-3 px-3 text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classes as $class)
                                <tr>
                                    <td class="px-3 fw-bold text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                {{ substr($class->name, 0, 1) }}
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size:0.88rem;">{{ $class->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge bg-light text-primary border px-2 py-1" style="border-radius:8px; font-size:0.78rem;">
                                            {{ $class->code ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge-completed">
                                            <i class="fa-solid fa-layer-group me-1"></i>{{ $class->category?->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-3">
                                        <small class="text-muted">{{ \Str::limit($class->description, 28) ?: '—' }}</small>
                                    </td>
                                    <td class="px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <button type="button" class="btn btn-action btn-sm btn-outline-warning" title="{{ __('Edit') }}"
                                                onclick="editClass('{{ $class->id }}', '{{ $class->name }}', '{{ $class->code }}', '{{ $class->school_category_id }}', '{{ $class->description }}')">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <form action="{{ route('classes.destroy', ['tenant' => auth()->user()->school->slug, 'class' => $class->id]) }}" method="POST" class="d-inline">
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
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                        {{ __('No classes found.') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($classes->hasPages())
                        <div class="p-3 border-top">
                            {{ $classes->links() }}
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
    function editClass(id, name, code, categoryId, description) {
        document.getElementById('form-title').innerHTML = '<i class="fa-solid fa-pen-to-square me-2"></i> {{ __("Update Class") }}: ' + name;
        document.getElementById('submit-btn').innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __("Update Class") }}';
        document.getElementById('cancel-btn').classList.remove('d-none');

        const form = document.getElementById('class-form');
        form.action = "{{ route('classes.update', ['tenant' => auth()->user()->school->slug, 'class' => ':id']) }}".replace(':id', id);
        
        const methodField = document.getElementById('method-field');
        methodField.innerHTML = '@method("PUT")';

        document.getElementById('name').value = name;
        document.getElementById('code').value = code;
        document.getElementById('school_category_id').value = categoryId;
        document.getElementById('description').value = description;

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('form-title').innerHTML = '<i class="fa-solid fa-plus me-2"></i> {{ __("Create Class") }}';
        document.getElementById('submit-btn').innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __("Create Class") }}';
        document.getElementById('cancel-btn').classList.add('d-none');

        const form = document.getElementById('class-form');
        form.action = "{{ route('classes.store', ['tenant' => auth()->user()->school->slug]) }}";
        form.reset();
        document.getElementById('method-field').innerHTML = '';
    }

    function confirmDelete(button) {
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('Do you want to delete this class?') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: "{{ __('Yes, delete it!') }}",
            cancelButtonText: "{{ __('Cancel') }}",
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
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection