@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Digital Diary</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <form action="" method="GET" class="d-flex">
                <input type="date" name="date" class="form-control" value="{{ request('date') ?? date('Y-m-d') }}" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Today's Entries ({{ date('d M, Y') }})</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>SL</th>
                              
                                    <th>Subject</th>
                                    <th>Lesson</th>
                                    <th>Homework</th>
                                    <th>Submission Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($diaries as $diary)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                   
                                    <td>{{ $diary->subject->name }}</td>
                                    <td>{{ Str::limit($diary->lesson_description, 30) }}</td>
                                    <td>{{ Str::limit($diary->homework, 30) }}</td>
                                    <td>{{ $diary->submission_date ? \Carbon\Carbon::parse($diary->submission_date)->format('d M, Y') : 'Not submitted' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info badge viewDiary" data-id="{{ $diary->id }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No entries found for today.</td>
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