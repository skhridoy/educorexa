@extends('layouts.school')
@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">{{ __('Select Class for ID Cards') }}</h6>
                        <form action="{{ route('students.idcard.preview', ['tenant' => auth()->user()->school->slug]) }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Select Class') }}</label>
                                <select name="class_id" class="form-control" required>
                                    <option value="">{{ __('Choose Class...') }}</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Preview ID Cards') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
