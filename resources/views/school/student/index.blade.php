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
                <h1 class="page-title"><i class="fa-solid fa-user-graduate me-2"></i> Students Management</h1>
                <p class="page-subtitle">Manage and view all students in your school</p>
            </div>
        </div>

        {{-- Search & Filters --}}
        <div class="search-card">
            <form id="searchForm" class="mb-0">
                <div class="row g-3">
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="student_id" placeholder="Search by Student ID">
                        <span class="clear-btn position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; display:none;">❌</span>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="name" placeholder="Search by Name">
                        <span class="clear-btn position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; display:none;">❌</span>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="contact" placeholder="Search by Contact">
                        <span class="clear-btn position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; display:none;">❌</span>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary w-100" style="padding: 12px; border-radius: 10px; font-weight: 600;">
                            <i class="fa-solid fa-magnifying-glass me-2"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Data Table Card --}}
        <div class="data-table-card">
            <div class="table-header">
                <h5 class="table-title"><i class="fa-solid fa-list me-2"></i> Active Students [{{ $activeStudents ?? 0 }}]</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('students.importForm', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-primary" style="border-radius: 8px;">
                        <i class="fa-solid fa-upload me-1"></i> Import
                    </a>
                    <a href="{{ route('students.export', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-success" style="border-radius: 8px;">
                        <i class="fa-solid fa-download me-1"></i> Export
                    </a>
                </div>
            </div>

            <div id="loadingSpinner" class="text-center py-5" style="display:none;">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-muted mt-2">Loading students...</p>
            </div>

            <div id="studentTable">
                @include('school.student.partials.table')
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
        text: "Do you want to delete this student?",
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
    })
}

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '{{ session('success') }}',
});
@endif


let debounceTimer;

// 🔥 Live Search
$('#searchForm input').on('keyup', function() {

    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(function() {
        loadStudents();
    }, 500);

    // Clear button show/hide
    let input = $(this);
    let clearBtn = input.siblings('.clear-btn');

    if (input.val().length > 0) {
        clearBtn.show();
    } else {
        clearBtn.hide();
    }
});

// 🔥 Manual Submit
$('#searchForm').on('submit', function(e) {
    e.preventDefault();
    loadStudents();
});

// 🔥 AJAX Pagination
$(document).on('click', '.pagination a', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');
    loadStudents(url);
});

// 🔥 Clear Button Click
$(document).on('click', '.clear-btn', function() {

    let input = $(this).siblings('input');

    input.val('');
    $(this).hide();

    loadStudents();
});


// 🔥 Main Load Function
function loadStudents(url = null) {
    $('#loadingSpinner').show();

    // সার্চ ফর্মের সব ডাটা অবজেক্ট আকারে নিন
    let formData = $('#searchForm').serialize();
    
    let finalUrl;

    if (url) {
        // যদি পেজিনেশন লিঙ্ক থেকে ইউআরএল আসে, সেটার সাথে সার্চ কুয়েরি অ্যাপেন্ড করুন
        // যাতে পেজ চেঞ্জ হলেও ফিল্টার ঠিক থাকে
        finalUrl = url + (url.includes('?') ? '&' : '?') + formData;
    } else {
        // প্রথমবার লোড বা সার্চ করার সময়
        finalUrl = "{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}?" + formData;
    }

    $.ajax({
        url: finalUrl,
        type: "GET",
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // এটি লারাভেলকে বুঝতে সাহায্য করে যে এটি AJAX রিকোয়েস্ট
        },
        success: function(data) {
            $('#studentTable').fadeOut(150, function() {
                $(this).html(data).fadeIn(150);
            });
            
            // ইউআরএল বার আপডেট করুন (ঐচ্ছিক, যাতে রিফ্রেশ দিলেও একই পেজে থাকে)
            window.history.pushState({}, null, finalUrl);
        },
        complete: function() {
            $('#loadingSpinner').hide();
        },
        error: function() {
            console.log('Error fetching data');
        }
    });
}

</script>
@endsection