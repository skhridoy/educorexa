@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Create Daily Diary') }}</h6>

                    {{-- মেসেজ দেখানোর সঠিক জায়গা --}}
                    @if(session('success'))
                        <div class="alert alert-{{ session('type') == 'error' ? 'danger' : 'success' }} alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('diary.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Date') }}</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Submission Date (Optional)') }}</label>
                                <input type="date" name="submission_date" class="form-control">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('Class') }}</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                <option value="">{{ __('Select Class') }}</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Section') }}</label>
                            <select name="section_id" id="section_id" class="form-control" required>
                                <option value="">{{ __('Select Section') }}</option>
                                {{-- যদি সেকশন কন্ট্রোলার থেকে আসে তবে এখানে লুপ হবে, অথবা AJAX দিয়ে লোড হবে --}}
                                @isset($sections)
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Subject') }}</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                <option value="">{{ __('Select Subject') }}</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('Today\'s Lesson') }}</label>
                            <textarea name="lesson_description" class="form-control" rows="3" placeholder="{{ __('What was taught today?') }}" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-danger">{{ __('Homework') }}</label>
                            <textarea name="homework" class="form-control" rows="3" placeholder="{{ __('Tomorrow\'s lesson/homework...') }}"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">{{ __('Save Diary') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Lesson Plan -->
            <div class="modal fade" id="editLessonPlanModal">
                <div class="modal-dialog">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Edit Lesson Plan</h5>
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
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Today\'s Entries') }} ({{ date('d M, Y') }})</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Class') }}</th>
                                    <th>{{ __('Subject') }}</th>
                                    <th>{{ __('Lesson') }}</th>
                                    <th>{{ __('Homework') }}</th>
                                    <th>{{ __('Submission Date') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($diaries as $diary)
                                <tr>
                                    <td>{{ $diary->class->name }}</td>
                                    <td>{{ $diary->subject->name }}</td>
                                    <td>{{ Str::limit($diary->lesson_description, 30) }}</td>
                                    <td>{{ Str::limit($diary->homework, 30) }}</td>
                                    <td>{{ $diary->submission_date ? \Carbon\Carbon::parse($diary->submission_date)->format('d M, Y') : 'Not submitted' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info badge editDiary" data-id="{{ $diary->id }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('diary.destroy', ['tenant' => auth()->user()->school->slug, 'diary' => $diary->id]) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger badge" onclick="return confirmDelete(this)">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No entries found for today.') }}</td>
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
    // ডিলিট কনফার্মেশন
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this diary entry?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // সাকসেস মেসেজ (SweetAlert)
    @if(session('success'))
        Swal.fire({
            icon: '{{ session('type', 'success') }}',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    @endif

    $(document).ready(function() {
        // ক্লাস পরিবর্তনের সাথে সাবজেক্ট লোড করা
        $('#class_id').on('change', function() {
            let classId = $(this).val();
            let subjectSelect = $('#subject_id');
            
            if(classId) {
                let url = "{{ route('get.subjects', ['tenant' => auth()->user()->school->slug, 'class_id' => ':classId']) }}";
                url = url.replace(':classId', classId);

                $.get(url, function(data) {
                    subjectSelect.empty().append('<option value="">Select Subject</option>');
                    $.each(data, function(key, value) {
                        subjectSelect.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                });
            } else {
                subjectSelect.empty().append('<option value="">Select Subject</option>');
            }
        });

        // ডায়েরি এডিট মোডাল ওপেন করা
        $(document).on('click', '.editDiary', function() {
            let id = $(this).data('id');
            let tenant = "{{ auth()->user()->school->slug }}";
            
            // আপনার ডায়েরি এডিট রাউট অনুযায়ী URL ঠিক করে নিন
            let url = "{{ route('diary.edit', ['tenant' => ':tenant', 'diary' => ':id']) }}"
                        .replace(':tenant', tenant)
                        .replace(':id', id);

            $.get(url, function(data) {
                let html = `
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="${data.date}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Submission Date</label>
                        <input type="date" name="submission_date" class="form-control" value="${data.submission_date || ''}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Today's Lesson</label>
                        <textarea name="lesson_description" class="form-control" rows="3" required>${data.lesson_description}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Homework</label>
                        <textarea name="homework" class="form-control" rows="3">${data.homework || ''}</textarea>
                    </div>
                `;

                $('#editBody').html(html);

                // আপডেট ইউআরএল সেট করা
                let updateUrl = "{{ route('diary.update', ['tenant' => ':tenant', 'diary' => ':id']) }}"
                                .replace(':tenant', tenant)
                                .replace(':id', id);
                
                $('#editForm').attr('action', updateUrl);

                // মোডাল শো করা
                var myModal = new bootstrap.Modal(document.getElementById('editLessonPlanModal'));
                myModal.show();
            });
        });
    });
</script>
@endsection