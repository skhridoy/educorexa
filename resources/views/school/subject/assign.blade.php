@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .pagination {
            --bs-pagination-border-radius: 50% !important;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-header-card mb-4">
                <div class="page-header-content">
                    <h1 class="page-title"><i class="fa-solid fa-layer-group me-2"></i> Assign Subjects</h1>
                    <p class="page-subtitle">Assign subjects to classes and manage current classroom assignments.</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="form-card">
                        <h5 class="mb-4 fw-bold text-primary"><i class="fa-solid fa-paper-plane me-2"></i> Assign Subject</h5>
                        <form id="assignSubjectForm" action="{{ route('subjects.assign.store', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                                <select id="class_id" name="class_id" class="form-select" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" data-category-id="{{ $class->school_category_id }}" data-category-name="{{ $class->category?->name }}">
                                            {{ $class->name }} @if($class->category) ({{ $class->category->name }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category_display" class="form-label">Category</label>
                                <input type="text" id="category_display" class="form-control" readonly placeholder="Category will show based on class">
                            </div>

                            <div class="mb-3">
                                <label for="school_sub_category_id" class="form-label">Sub Category</label>
                                <select id="school_sub_category_id" name="school_sub_category_id" class="form-select" disabled>
                                    <option value="">Select Class First</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                                <select id="subject_id" name="subject_id" class="form-select" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="full_mark" class="form-label">Full Mark <span class="text-danger">*</span></label>
                                <input type="text" id="full_mark" name="full_mark" class="form-control" placeholder="Enter full mark" required>
                            </div>

                            <div class="mb-3">
                                <label for="pass_mark" class="form-label">Pass Marks <span class="text-danger">*</span></label>
                                <input type="text" id="pass_mark" name="pass_mark" class="form-control" placeholder="Pass Marks" required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary-gradient flex-grow-1">Assign</button>
                                <a href="{{ route('subjects.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-outline-secondary flex-grow-1">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="data-table-card">
                        <div class="table-header">
                            <h5 class="table-title"><i class="fa-solid fa-table-list me-2"></i> Assigned Subjects</h5>
                            <select id="filterClassId" name="class_id" class="form-select form-select-sm" style="min-width: 180px;">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="assignTable" class="table-responsive px-3 pb-3">
                            @include('school.subject.partials.assign-table')
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
                text: "Do you want to delete this assignment?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
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
                confirmButtonColor: '#3085d6',
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

        $('#filterClassId').on('change', function() {
            loadAssignments();
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            loadAssignments($(this).attr('href'));
        });

        $('#class_id').on('change', function() {
            const classId = $(this).val();
            const categoryId = $(this).find(':selected').data('category-id');
            const categoryName = $(this).find(':selected').data('category-name') || '';

            $('#category_display').val(categoryName ? categoryName : 'No category');
            $('#school_sub_category_id').empty().append('<option value="">Select Sub Category</option>').prop('disabled', true);

            if (!classId) {
                $('#category_display').val('');
                return;
            }

            if (categoryId) {
                $.ajax({
                    url: "{{ route('get.subcategories', ['tenant' => auth()->user()?->school?->slug, 'categoryId' => 'CATEGORY_ID']) }}".replace('CATEGORY_ID', categoryId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#school_sub_category_id').prop('disabled', false);
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                $('#school_sub_category_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        } else {
                            $('#school_sub_category_id').append('<option value="">No subcategories found</option>');
                        }
                    }
                });
            }
        });

        $('#school_sub_category_id').on('change', function() {
            // Subjects are loaded server-side, no AJAX needed
        });

        $('#assignSubjectForm').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const action = form.attr('action');
            const data = form.serialize();

            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Assigned!',
                        text: response.message || 'Subject assigned successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    form[0].reset();
                    $('#category_display').val('');
                    $('#school_sub_category_id').prop('disabled', true).empty().append('<option value="">Select Class First</option>');
                    $('#subject_id').prop('disabled', true).empty().append('<option value="">Select Class First</option>');
                    loadAssignments();
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        const message = Object.values(errors).flat()[0];
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation failed',
                            text: message,
                        });
                        return;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Unable to assign subject. Please try again.',
                    });
                }
            });
        });

        function loadAssignments(url = null) {
            if (!url) {
                url = "{{ route('subjects.assign', ['tenant' => auth()->user()?->school?->slug]) }}";
            }
            const query = $('#filterClassId').serialize();
            if (query) {
                url += '?' + query;
            }
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#assignTable').html(data);
                }
            });
        }
    </script>
@endsection