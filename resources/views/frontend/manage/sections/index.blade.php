@extends('layouts.main') {{-- আপনার মেইন অ্যাডমিন লেআউট --}}

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Frontend</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Sections</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Home Page Sections</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Section Title</th>
                                <th>Key</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sections as $section)
                            <tr>
                                <td>{{ $section->order }}</td>
                                <td>{{ $section->title }}</td>
                                <td><span class="badge bg-light text-dark">{{ $section->key }}</span></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input status-toggle" 
                                               data-id="{{ $section->id }}"
                                               {{ $section->status ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('manage.frontend.edit', $section->id) }}" class="btn btn-sm btn-primary btn-icon-text">
                                        <i class="btn-icon-prepend" data-feather="edit"></i> Edit
                                    </a>
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
@endsection

@push('customJs')
<script>
$(function() {
    // CSRF Token Setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // AJAX Status Update
    $('.status-toggle').on('change', function() {
        let status = $(this).prop('checked') ? 1 : 0;
        let sectionId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "{{ route('manage.frontend.update.status') }}",
            data: {
                id: sectionId,
                status: status
            },
            success: function(data) {
                // NobleUI এর ডিফল্ট টোস্ট বা এলার্ট ব্যবহার করতে পারেন
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
            },
            error: function(err) {
                console.log(err);
                alert('Something went wrong!');
            }
        });
    });
});
</script>
@endpush