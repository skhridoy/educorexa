@extends('layouts.school')

@section('customCSS')
    <style>
        
    </style>
@endsection
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Teacher Details</h6>
                    <p class="card-description">View detailed information about the teacher.</p>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Teacher Information</h6>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <th>ID</th>
                                                    <td>{{ $teacher->teacher_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td class="text-uppercase">{{ $teacher->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Father's Name</th>
                                                    <td>{{ $teacher->father_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Mother's Name</th>
                                                    <td>{{ $teacher->mother_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Subject</th>
                                                    <td>{{ $teacher->subject->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Qualification</th>
                                                    <td>{{ $teacher->qualification }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{ $teacher->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td>{{ $teacher->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $teacher->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Joining Date</th>
                                                    <td>{{ $teacher->joining_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th>
                                                    <td class="text-capitalize">{{ $teacher->gender }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Date of Birth</th>
                                                    <td>{{ $teacher->date_of_birth }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Blood Group</th>
                                                    <td>{{ $teacher->blood_group }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">{{ $teacher->name }}</h4>
                                    <img style="border: 3px solid gold" src="{{ asset($teacher->photo) }}" alt="Profile Image" class="img-fluid rounded-circle profile mx-auto d-block">
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('teachers.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-secondary mt-3">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection