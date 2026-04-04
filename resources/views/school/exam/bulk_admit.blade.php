@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="card-title">Generate Admit Cards</h6>
            <form action="{{ request()->url() }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <select name="class_id" class="form-control" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="exam_id" class="form-control" required>
                            <option value="">Select Exam</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Search & Preview</button>
                        
                        @if(isset($students) && $students->count() > 0)
                            <a href="{{ route('exam.bulk_admit_card', ['tenant' => auth()->user()->school->slug, 'class_id' => request('class_id'), 'exam_id' => request('exam_id')]) }}" 
                               target="_blank" class="btn btn-success">
                               <i class="link-icon" data-feather="download"></i> Download PDF
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- প্রিভিউ সেকশন শুরু --}}
    @if(isset($students) && $students->count() > 0)
    <div class="row">
        <div class="col-md-12 mb-3">
            <h5 class="text-muted">Admit Card Preview (Total: {{ $students->count() }})</h5>
            <hr>
        </div>
        
        @foreach($students as $student)
        <div class="col-md-6 mb-4">
            <div class="card shadow-none border border-dark" style="background-color: #fff; position: relative; overflow: hidden; min-height: 280px;">
                
                {{-- ওয়াটারমার্ক (Watermark) লজিক --}}
                <div style="position: absolute; top: 55%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1; z-index: 0; pointer-events: none;">
                        <img src="{{ asset($schoolLogo) }}" style="width: 200px;">
                </div>

                {{-- কার্ড কন্টেন্ট (z-index: 1 দিয়ে ওয়াটারমার্কের উপরে রাখা হয়েছে) --}}
                <div style="position: relative; z-index: 1;">
                    {{-- হেডার --}}
                    <div class="card-header bg-light border-bottom border-dark text-center py-2">
                        <h5 class="mb-0 fw-bold text-dark">{{ auth()->user()->school->name }}</h5>
                        <p class="mb-0 small text-dark">{{ $selected_exam->name }}</p>
                    </div>

                    <div class="card-body p-3">
                        <div class="row">
                            {{-- স্টুডেন্ট ডাটা --}}
                            <div class="col-8">
                                <table class="m-0 table table-sm table-borderless mb-0" style="font-size: 13px; background: transparent;">
                                    <tr><td class="fw-bold">Roll</td><td>: {{ $student->roll }}</td></tr>
                                    <tr><td width="30%" class="fw-bold">ID</td><td>: {{ $student->student_id }}</td></tr>
                                    <tr><td class="fw-bold">Name</td><td>: {{ $student->name }}</td></tr>
                                    <tr><td class="fw-bold">Class</td><td>: {{ $student->class->name }}</td></tr>
                                    <tr><td class="fw-bold">Session</td><td>: {{ date('Y') }}</td></tr>
                                </table>
                            </div>

                            {{-- ফটো এবং কিউআর কোড --}}
                            <div class="col-4 text-center">
                                <div class="border border-secondary mb-2 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: #fff;">
                                    @if($student->photo)
                                        <img src="{{ asset($student->photo) }}" class="img-fluid h-100 w-100 object-fit-cover">
                                    @else
                                        <small class="text-muted">Photo</small>
                                    @endif
                                </div>

                                {{-- কিউআর কোড --}}
                                <div class="mt-2">
                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(45)->color(106, 27, 154)->generate("ID: " . $student->student_id . " | Name: " . $student->name) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ফুটার (সিগনেচার) --}}
                    <div class="card-footer bg-transparent border-0 py-3">
                        <div class="d-flex justify-content-between mx-2">
                            <div class="text-center">
                                <div style="border-top: 1px solid #000; width: 100px;" class="small">Class Teacher</div>
                            </div>
                            <div class="text-center">
                                <div style="border-top: 1px solid #000; width: 100px;" class="small">Principal</div>
                            </div>
                        </div>
                    </div>
                </div> {{-- কন্টেন্ট শেষ --}}
            </div>
        </div>
        @endforeach
    </div>
    @elseif(request('class_id'))
        <div class="alert alert-info">এই ক্লাসে কোনো স্টুডেন্ট পাওয়া যায়নি।</div>
    @endif
</div>
@endsection