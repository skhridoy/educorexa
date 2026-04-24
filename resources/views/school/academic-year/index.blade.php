@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h6 class="card-title">Create Academic Year</h6>
                        <form action="{{ route('academic-year.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-end">Create</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Academic Years</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Status</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($academicYears as $academicYear)
                                    <tr>
                                        <td>{{ $academicYear->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($academicYear->start_date)->format('d-M-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($academicYear->end_date)->format('d-M-Y') }}</td>
                                        <td>
                                            @if($academicYear->is_active)
                                                <form action="{{ route('academic-year.toggleInactive', ['academic_year' => $academicYear->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary badge">Active</button>
                                            </form>
                                            @else
                                                <form action="{{ route('academic-year.toggleActive', ['academic_year' => $academicYear->id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-secondary badge">Inactive</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-warning badge">Edit</a>

                                            
                                            <form action="{{ route('academic-year.destroy', ['academic_year' => $academicYear->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger badge">Delete</button>
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
