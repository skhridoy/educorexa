@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body"> 

                        <h6 class="card-title">Create Exam</h6>
                        <form action="{{ route('exams.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Exam Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" placeholder="উদা: ১ম সাময়িক পরীক্ষা" value="{{ old('name') }}" required>
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
                            </div>

                            <div class="mb-3">
                                <label for="school_category_id" class="form-label">School Category</label>
                                <select class="form-select @error('school_category_id') is-invalid @enderror" name="school_category_id" required>
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('school_category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Create Exam</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit exam -->
            <div class="modal fade" id="editExamModal">
                <div class="modal-dialog">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Edit Exam</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body" id="editBody">
                                <!-- Dynamic Content Load হবে -->
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary">Update</button>
                            </div>
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
                                                    action="{{ route('exams.destroy', ['tenant' => auth()->user()->school->slug, 'exam' => $exam->id]) }}"
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
                url: "{{ route('exams.status', ['tenant' => auth()->user()->school->slug, 'exam' => ':id']) }}"
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
                url: "{{ route('exams.publish', ['tenant' => auth()->user()->school->slug, 'exam' => ':id']) }}"
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

            $.get("{{ route('exams.edit', ['tenant' => auth()->user()->school->slug, 'exam' => ':id']) }}"
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
                        "{{ route('exams.update', ['tenant' => auth()->user()->school->slug, 'exam' => ':id']) }}"
                            .replace(':id', id)
                    );

                    $('#editExamModal').modal('show');
                }
            );
        });
    </script>
@endsection