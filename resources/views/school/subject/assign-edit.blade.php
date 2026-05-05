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
                    <h1 class="page-title"><i class="fa-solid fa-edit me-2"></i> Edit Subject Assignment</h1>
                    <p class="page-subtitle">Update subject assignment details for a class.</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="form-card">
                        <h5 class="mb-4 fw-bold text-primary"><i class="fa-solid fa-pencil me-2"></i> Update Assignment</h5>
                        <form id="assignSubjectForm" action="{{ route('subjects.assign.update', ['tenant' => auth()->user()?->school?->slug, 'assignment' => $assignment->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                                <select id="class_id" name="class_id" class="form-select" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" data-category-id="{{ $class->school_category_id }}" data-category-name="{{ $class->category?->name }}" {{ old('class_id', $assignment->class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }} @if($class->category) ({{ $class->category->name }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ক্যাটাগরি ডিসপ্লে এবং হিডেন ID -->
                            <div class="mb-3">
                                <label for="category_display" class="form-label">Category</label>
                                <input type="text" id="category_display" class="form-control" readonly 
                                    placeholder="Category will show based on class"
                                    value="{{ $assignment->class->category?->name ?? '' }}">
                                
                                <!-- আসল ID পাঠানোর জন্য এই হিডেন ইনপুটটি যোগ করুন -->
                                <input type="hidden" name="school_category_id" id="school_category_id" 
                                    value="{{ old('school_category_id', $assignment->school_category_id) }}">
                            </div>

                            <!-- সাব-ক্যাটেগরি সিলেক্ট (name="school_sub_category_id" যুক্ত করুন) -->
                            <div class="mb-3">
                                <label for="school_sub_category_id" class="form-label">Sub Category</label>
                                <select id="school_sub_category_id" name="school_sub_category_id" class="form-select" {{ !isset($assignment->school_sub_category_id) ? 'disabled' : '' }}>
                                    <option value="">Select Sub Category</option>
                                    @if(isset($assignment->class) && $assignment->class->school_category_id)
                                        @foreach($assignment->class->category?->subcategories ?? [] as $sub)
                                            <option value="{{ $sub->id }}" {{ old('school_sub_category_id', $assignment->school_sub_category_id) == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                                <select id="subject_id" name="subject_id" class="form-select" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id', $assignment->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="full_mark" class="form-label">Full Mark <span class="text-danger">*</span></label>
                                <input type="number" id="full_mark" name="full_mark" class="form-control" placeholder="Enter full mark" value="{{ old('full_mark', $assignment->full_mark) }}" required>
                                @error('full_mark')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pass_mark" class="form-label">Pass Marks <span class="text-danger">*</span></label>
                                <input type="number" id="pass_mark" name="pass_mark" class="form-control" placeholder="Pass Marks" value="{{ old('pass_mark', $assignment->pass_mark) }}" required>
                                @error('pass_mark')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary-gradient flex-grow-1">
                                    <i class="fa-solid fa-save me-2"></i> Update
                                </button>
                                <a href="{{ route('subjects.assign', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="fa-solid fa-times me-2"></i> Cancel
                                </a>
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
            // হিডেন ফিল্ডে আইডি সেট করুন (এটিই ডাটাবেসে যাবে)
            $('#school_category_id').val(categoryId); 
            
            // নাম ডিসপ্লে ফিল্ডে সেট করুন
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
            // সাবমিট করার আগে সাব-ক্যাটেগরি এনাবল করুন যাতে ডাটা রিকোয়েস্টে যায়
            $('#school_sub_category_id').prop('disabled', false);
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
                        title: 'Updated!',
                        text: response.message || 'Subject assignment updated successfully',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route('subjects.assign', ['tenant' => auth()->user()?->school?->slug]) }}';
                    });
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
                        text: 'Unable to update assignment. Please try again.',
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