@extends('layouts.school');

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Add Daily Diary</h6>
                        <form action="{{ route('diary.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Class</label>
                                    <select name="class_id" class="form-control select2" required>
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Subject</label>
                                    <select name="subject_id" class="form-control select2" required>
                                        <option value="">Select Subject</option>
                                        {{-- Ajax দিয়ে ক্লাস অনুযায়ী সাবজেক্ট লোড হবে --}}
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Submission Date (Optional)</label>
                                    <input type="date" name="submission_date" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Today's Lesson (আজকের পাঠ)</label>
                                <textarea name="lesson_description" class="form-control" rows="3" placeholder="আজ ক্লাসে কী পড়ানো হলো..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-danger">Homework / Next Day Lesson (আগামী দিনের পড়া)</label>
                                <textarea name="homework" class="form-control" rows="3" placeholder="বাড়ির কাজ বা আগামী দিনের পড়া লিখুন..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Diary</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection