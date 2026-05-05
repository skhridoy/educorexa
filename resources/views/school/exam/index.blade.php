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
                <h1 class="page-title"><i class="fa-solid fa-pen me-2"></i> Exams Management</h1>
                <p style="margin: 0; opacity: 0.85;">Create and manage exams for your school</p>
            </div>
        </div>

        <div class="row">
            {{-- Form Column --}}
            <div class="col-lg-4 mb-4">
                <div class="form-card">
                    <h6 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-plus me-2"></i> Create Exam
                    </h6>
                    <form action="{{ route('exams.store', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Exam Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" placeholder="e.g., 1st Semester Exam" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="year_id" class="form-label">Academic Year</label>
                            <select class="form-select @error('year_id') is-invalid @enderror" id="year_id" name="year_id" required>
                                <option value="" selected disabled>Select Year</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->id }}" {{ old('year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('year_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="school_category_id" class="form-label">Category</label>
                            <select class="form-select @error('school_category_id') is-invalid @enderror" name="school_category_id" required>
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('school_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('school_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-gradient w-100">
                            <i class="fa-solid fa-check me-1"></i> Create Exam
                        </button>
                    </form>
                </div>
            </div>

            {{-- Exams List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header">
                        <h5 class="table-title"><i class="fa-solid fa-list me-2"></i> All Exams</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Year</th>
                                    <th>Category</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exams as $exam)
                                <tr>
                                    <td data-label="Name" style="font-weight: 600;">{{ $exam->name }}</td>
                                    <td data-label="Year">{{ $exam->year?->name ?? 'N/A' }}</td>
                                    <td data-label="Category">{{ $exam->category?->name ?? 'N/A' }}</td>
                                    <td data-label="Start Date">{{ $exam->start_date ? $exam->start_date->format('d M, Y') : 'N/A' }}</td>
                                    <td data-label="End Date">{{ $exam->end_date ? $exam->end_date->format('d M, Y') : 'N/A' }}</td>
                                    <td data-label="Actions" class="text-center">
                                        <button type="button" class="btn btn-action btn-sm btn-outline-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editExamModal" onclick="loadEditForm({{ $exam->id }})">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('exams.destroy', ['tenant' => auth()->user()?->school?->slug, 'exam' => $exam->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-action btn-sm btn-outline-danger" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fa-solid fa-inbox fa-3x mb-3" style="color:#e2e8f0;"></i>
                                        <p class="text-muted">No exams found.</p>
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

<!-- Edit exam modal -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Exams</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Year</th>
                                        <th>Start - End Date</th>
                                        <th>Status</th>
                                        <th>Published</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exams as $exam)
                                        <tr>
                                            <td>{{ $exam->name }}</td>
                                            <td>{{ $exam->academicYear->name ?? '' }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($exam->start_date)->format('d M') }} 
                                                - 
                                                {{ \Carbon\Carbon::parse($exam->end_date)->format('d M') }}
                                            </td>
                                            
                                            <td>
                                                @php
                                                $state = $exam->exam_state;
                                                @endphp

                                                @if($state == 'ongoing')
                                                    <span class="badge bg-success statusBadge"
                                                        data-id="{{ $exam->id }}"
                                                        data-year="{{ $exam->year_id }}">
                                                        Ongoing
                                                    </span>

                                                @elseif($state == 'upcoming')
                                                    <span class="badge bg-warning text-dark statusBadge"
                                                        data-id="{{ $exam->id }}"
                                                        data-year="{{ $exam->year_id }}">
                                                        Upcoming
                                                    </span>

                                                @elseif($state == 'finished')
                                                    <span class="badge bg-danger statusBadge"
                                                        data-id="{{ $exam->id }}"
                                                        data-year="{{ $exam->year_id }}">
                                                        Finished
                                                    </span>

                                                @else
                                                    <span class="badge bg-secondary statusBadge"
                                                        data-id="{{ $exam->id }}"
                                                        data-year="{{ $exam->year_id }}">
                                                        Inactive
                                                    </span>
                                                @endif

                                            </td>
                                            <td>
                                                @if ($exam->status == 1)
                                                    
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input resultToggle" 
                                                        type="checkbox" 
                                                        role="switch"
                                                        data-id="{{ $exam->id }}" 
                                                        {{ $exam->is_published ? 'checked' : '' }}>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="d-flex px-3">
                                                <button class="  btn btn-sm btn-info badge editBtn" data-id="{{ $exam->id }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>


                                                <form
                                                    action="{{ route('exams.destroy', ['tenant' => auth()->user()?->school?->slug, 'exam' => $exam->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)"
                                                        class="mx-2 btn btn-sm btn-danger badge">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input statusToggle"
                                                        type="checkbox"
                                                        data-id="{{ $exam->id }}"
                                                        data-year="{{ $exam->year_id }}"
                                                        {{ $exam->status ? 'checked' : '' }}>
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
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this subject?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',

            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    button.closest('form').submit();

                }
            })
        }
        @if(session('success'))
            Swal.fire({
                icon: '{{ session('type', 'success') }}',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 1500,
                showConfirmButton: false
            });
        @endif

        $(document).on('change', '.statusToggle', function () {

            let examId = $(this).data('id');
            let yearId = $(this).data('year');
            let toggle = $(this);

            $.ajax({
                url: "{{ route('exams.status', ['tenant' => auth()->user()?->school?->slug, 'exam' => ':id']) }}"
                    .replace(':id', examId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {

                    if (response.success) {


                        // 🔥 Same year সব badge inactive
                        $('.statusBadge').each(function () {

                            if ($(this).data('year') == yearId) {

                                $(this)
                                    .removeClass('bg-success')
                                    .addClass('bg-secondary')
                                    .text('Inactive');
                            }
                        });

                        // 🔥 Same year সব toggle off
                        $('.statusToggle').each(function () {

                            if ($(this).data('year') == yearId) {
                                $(this).prop('checked', false);
                            }
                        });

                        // 🔥 Current exam active
                        if (response.new_status == 1) {

                            $('.statusBadge[data-id="' + examId + '"]')
                                .removeClass('bg-secondary')
                                .addClass('bg-success')
                                .text('Active');

                            toggle.prop('checked', true);
                        }

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated',
                                timer: 1000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Swal শেষ হওয়ার পর রিলোড হবে
                            });
                        }

                    }
                }
            });

        });

        // Result publish toggle
        $(document).on('change', '.resultToggle', function () {

            let examId = $(this).data('id');
            let toggle = $(this);

            $.ajax({
                url: "{{ route('exams.publish', ['tenant' => auth()->user()?->school?->slug, 'exam' => ':id']) }}"
                    .replace(':id', examId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Publish Status Updated',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                }
            });

        });
        $(document).on('click','.editBtn',function(){

            let id = $(this).data('id');

            $.get("{{ route('exams.edit', ['tenant' => auth()->user()?->school?->slug, 'exam' => ':id']) }}"
                .replace(':id', id),

                function(data){

                    let html = `
                        <div class="mb-3">
                            <label>Academic Year</label>
                            <select name="year_id" class="form-control" required>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}"
                                        ${data.year_id == {{ $year->id }} ? 'selected' : ''}>
                                        {{ $year->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Exam Name</label>
                            <input type="text" name="name" class="form-control"
                                value="${data.name}" required>
                        </div>

                        <div class="mb-3">
                            <label>Start Date</label>
                            <input type="date" name="start_date"
                                class="form-control"
                                value="${data.start_date}" required>
                        </div>

                        <div class="mb-3">
                            <label>End Date</label>
                            <input type="date" name="end_date"
                                class="form-control"
                                value="${data.end_date}" required>
                        </div>
                    `;

                    $('#editBody').html(html);

                    $('#editForm').attr(
                        'action',
                        "{{ route('exams.update', ['tenant' => auth()->user()?->school?->slug, 'exam' => ':id']) }}"
                            .replace(':id', id)
                    );

                    $('#editExamModal').modal('show');
                }
            );
        });
    </script>
@endsection