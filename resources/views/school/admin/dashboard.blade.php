@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Welcome to Admin Dashboard</h4>
                <span>Good Morning, {{ Auth::user()->name }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">
                    <div class="col-6 col-md-6 col-xl-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="card-title mb-0">Total Students</h6>
                                </div> 
                                <div class="row d-flex align-items-stretch">
                                    <div class="col-6 col-md-6 col-xl-5">
                                        <h3 class="mb-2">{{ $totalStudents }}</h3>
                                        <small class="text-muted">Enrolled</small>
                                    </div>
                                    <div class="col-6 col-md-6 col-xl-5 bg-opacity-10 ms-auto icon-large float-end d-flex align-items-top justify-content-center ">
                                        <i data-feather="users" class="text-primary icon-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-xl-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="card-title mb-0">Total Teachers</h6>
                                </div> 
                                <div class="row d-flex align-items-stretch">
                                    <div class="col-6 col-md-6 col-xl-5">
                                        <h3 class="mb-2">{{ $totalTeachers }}</h3>
                                        <small class="text-muted">Enrolled</small>
                                    </div>
                                    <div class="col-6 col-md-6 col-xl-5 bg-opacity-10 ms-auto icon-large float-end d-flex align-items-top justify-content-center ">
                                        <i data-feather="users" class="text-primary icon-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-xl-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="card-title mb-0">Total Subjects</h6>
                                </div> 
                                <div class="row d-flex align-items-stretch">
                                    <div class="col-6 col-md-6 col-xl-5">
                                        <h3 class="mb-2">{{ $totalSubjects }}</h3>
                                        <small class="text-muted">Available</small>
                                    </div>
                                    <div class="col-6 col-md-6 col-xl-5 bg-opacity-10 ms-auto icon-large float-end d-flex align-items-top justify-content-center ">
                                        <i data-feather="book" class="text-primary icon-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-xl-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="card-title mb-0">Total Classes</h6>
                                </div> 
                                <div class="row d-flex align-items-stretch">
                                    <div class="col-6 col-md-6 col-xl-5">
                                        <h3 class="mb-2">{{ $totalClasses }}</h3>
                                        <small class="text-muted">Enrolled</small>
                                    </div>
                                    <div class="col-6 col-md-6 col-xl-5 bg-opacity-10 ms-auto icon-large float-end d-flex align-items-top justify-content-center ">
                                        <i data-feather="users" class="text-primary icon-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->

        <!-- Attendence Report -->
        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Attendance Report</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Example data, replace with actual attendance records -->
                                    <tr>
                                        <td>John Doe</td>
                                        <td>2024-06-01</td>
                                        <td><span class="badge bg-success">Present</span></td>
                                    </tr>
                                    <tr>
                                        <td>Jane Smith</td>
                                        <td>2024-06-01</td>
                                        <td><span class="badge bg-danger">Absent</span></td>
                                    </tr>
                                    <!-- Add more records as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->                                      
    </div>
                            
@endsection
