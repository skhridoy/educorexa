@extends('layouts.school')

@section('customCSS')
    <style>
        .table td .profile {
            width: 30px!important;
            height: 30px!important;
            border-radius: 100%;
        }
    </style>
@endsection
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Teachers</h6>
                    <p class="card-description">Manage your school's teachers here. You can add, edit, or view details of each teacher.</p>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Qualification</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                <tr>
                                    <td class="py-1">
                                        @if($teacher->photo)
                                            <img style="border: 2px solid gold" src="{{ asset($teacher->photo) }}" alt="image" >
                                        @else
                                            <img style="border: 2px solid gold" src="{{ asset('admin/dist/img/avatar3.png') }}" alt="image" >
                                        @endif 
                                    </td>
                                    <td>{{ $teacher->teacher_id }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->subject->name }}</td>
                                    <td>{{ $teacher->qualification }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary badge" href="{{ route('teachers.show', ['tenant' => auth()->user()->school->slug, 'teacher' => $teacher->id]) }}">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a class="btn btn-sm btn-warning badge" href="{{ route('teachers.edit', ['tenant' => auth()->user()->school->slug, 'teacher' => $teacher->id]) }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <!-- Add delete functionality if needed -->
                                        <form class="m-0" action="{{ route('teachers.destroy', ['tenant' => auth()->user()->school->slug,'teacher' => $teacher->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-sm btn-danger badge"><i class="fa-solid fa-trash"></i></button>
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

    feather.replace({ width: '24', height: '24' });
</script>
@endsection