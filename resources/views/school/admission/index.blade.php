@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-4">
            <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="card-title">Online Admissions</h6>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Adm Id</th>
                                        <th>Year</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Father Name</th>
                                        <th>Mother Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admissions as $admission)
                                    <tr>
                                        <td>
                                            @if($admission->photo)
                                                <img src="{{ asset($admission->photo) }}" alt="image" class="profile">
                                                @else
                                                <img src="{{ asset('admin/dist/img/avatar3.png') }}" alt="image" class="profile">
                                            @endif 
                                        </td>
                                        <td>{{ $admission->admission_number }}</td>
                                        <td>{{ $admission->academicYear->name ?? 'N/A' }}</td>
                                        <td>{{ $admission->class->name ?? 'N/A' }}</td>
                                        <td>{{ $admission->section->name ?? 'N/A' }}</td>
                                        <td>{{ $admission->name }}</td>
                                        <td>{{ $admission->contact_number }}</td>
                                        <td>{{ $admission->fathers_name }}</td>
                                        <td>{{ $admission->mothers_name }}</td>
                                        <td>
                                            @if($admission->status == 'pending')
                                                <form action="{{ route('admissions.approve', ['tenant' => auth()->user()->school->slug, 'admission' => $admission->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary badge">Approve</button>
                                            </form>
                                            @endif
                                            <form action="{{ route('admissions.reject', ['tenant' => auth()->user()->school->slug, 'admission' => $admission->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="confirmDelete(this)" type="button" class="btn btn-sm btn-danger badge">Reject</button>
                                            </form>
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
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
    });
    @endif
</script>
@endsection