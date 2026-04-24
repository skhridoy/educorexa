@extends('layouts.school')
@section('customCSS')
<style>
    .pagination{
        justify-content: center;
        
    }

    /* pagination item */
    .pagination .page-link{
    border-radius: 50%!important;
        margin: 0 4px;
        width: 32px;
        height: 33px;
        display:flex;
        align-items:center;
        justify-content:center;
        transition: all .2s ease;
    }

    /* hover */
    .pagination .page-link:hover{
        background:#0d6efd;
        color:#fff;
        border-color:#0d6efd;
    }

    /* active page */
    .pagination .page-item.active .page-link{
        background:#0d6efd;
        border-color:#0d6efd;

        color:#fff;
    }

    /* remove focus shadow */
    .pagination .page-link:focus{
        box-shadow:none;
    }
</style>
@endsection
@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-4">
            <div class="card">
                
                    <div class="card-body">
                        <form id="searchForm" class="mb-4">
                            <div class="row">

                                <div class="col-lg-3 mb-3">
                                    <div class="position-relative">
                                        <input type="text"
                                            class="form-control pe-5"
                                            name="student_id"
                                            placeholder="Search by student id">

                                        <span class="clear-btn position-absolute top-50 end-0 translate-middle-y me-3"
                                            style="cursor:pointer; display:none;">
                                            ❌
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="position-relative">
                                        <input type="text" class="form-control"
                                        name="name"
                                        placeholder="Search by name">
                                        <span class="clear-btn position-absolute top-50 end-0 translate-middle-y me-3"
                                            style="cursor:pointer; display:none;">
                                            ❌
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="position-relative">
                                    <input type="text" class="form-control"
                                        name="contact"
                                        placeholder="Search by contact">
                                        <span class="clear-btn position-absolute top-50 end-0 translate-middle-y me-3"
                                            style="cursor:pointer; display:none;">
                                            ❌
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit"
                                            class="form-control btn btn-primary">
                                        Refresh
                                    </button>
                                </div>

                            </div>
                        </form>
                        <div class="row d-flex">
                            <div class="col-md-6">
                                <h6 class="card-title">Active Students [{{ $activeStudents }}]</h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('students.export', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-success btn-sm">
                                    Export
                                </a>
                                <a href="{{ route('students.importForm', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-success btn-sm">
                                    import
                                </a>
                            </div>
                        </div>
                        <div id="loadingSpinner" class="text-center my-3" style="display:none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div id="studentTable">
                            @include('school.student.partials.table')
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

    let query = $('#searchForm').serialize();

    if (!url) {
        url = "{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}?" + query;
    }

    $.ajax({
        url: url,
        type: "GET",
        success: function(data) {

            // Smooth fade animation
            $('#studentTable').fadeOut(150, function() {
                $(this).html(data).fadeIn(150);
            });

        },
        complete: function() {
            $('#loadingSpinner').hide();
        },
        error: function() {
            alert('Something went wrong');
        }
    });
}

</script>
@endsection