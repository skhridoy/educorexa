@extends('layouts.school')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h4 class="mb-1"><i class="fa-solid fa-clipboard-check text-primary me-2"></i>{{ __('Exam Attendance') }}</h4>
            <p class="text-muted mb-0">{{ __('Print class sheets and record attendance by scanning admit card QR codes.') }}</p>
        </div>
        @if($examId && $classId)
            <a class="btn btn-outline-primary" target="_blank" href="{{ route('exam.attendance.report', ['tenant' => $tenant, 'exam_id' => $examId, 'class_id' => $classId, 'date' => $date]) }}">
                <i class="fa-solid fa-print me-1"></i>{{ __('Print Attendance Report') }}
            </a>
            <a class="btn btn-outline-secondary" href="{{ route('exam.attendance.download', ['tenant' => $tenant, 'exam_id' => $examId, 'class_id' => $classId]) }}">
                <i class="fa-solid fa-download me-1"></i>{{ __('Download Student Sheets') }}
            </a>
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form class="row g-2 align-items-end" method="get">
                <div class="col-md-4"><label class="form-label">{{ __('Exam') }}</label><select name="exam_id" class="form-select" required><option value="">{{ __('Select exam') }}</option>@foreach($exams as $exam)<option value="{{ $exam->id }}" @selected($examId == $exam->id)>{{ $exam->name }}</option>@endforeach</select></div>
                <div class="col-md-3"><label class="form-label">{{ __('Class') }}</label><select name="class_id" class="form-select" required><option value="">{{ __('Select class') }}</option>@foreach($classes as $class)<option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>@endforeach</select></div>
                <div class="col-md-3"><label class="form-label">Exam date</label><select name="date" class="form-select"><option value="">Select exam date for QR scan</option>@foreach($routines->unique(fn($routine) => optional($routine->exam_date)->format('Y-m-d')) as $routine)<option value="{{ optional($routine->exam_date)->format('Y-m-d') }}" @selected($date === optional($routine->exam_date)->format('Y-m-d'))>{{ optional($routine->exam_date)->format('d M Y') }} - {{ $routine->subject?->name }}</option>@endforeach</select></div>
                <div class="col-md-2"><button class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i>{{ __('Load') }}</button></div>
            </form>
        </div>
    </div>

    @if($examId && $classId)
        <div class="row g-3">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold"><i class="fa-solid fa-qrcode me-2 text-primary"></i>{{ __('Scan Admit Card QR') }}</div>
                    <div class="card-body">
                        <div id="exam-qr-reader" class="border rounded mb-3"></div>
                        <form id="exam-manual-form" class="input-group"><input id="exam-manual-code" class="form-control" placeholder="{{ __('Enter student ID') }}"><button class="btn btn-primary"><i class="fa-solid fa-check"></i></button></form>
                        <div id="exam-scan-message" class="small mt-3"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between"><span class="fw-bold">{{ __('Class Attendance') }}</span><span><b id="present-count">{{ $records->where('status', 'present')->count() }}</b> / {{ $students->count() }} {{ __('Present') }}</span></div>
                    <div class="table-responsive"><table class="table table-sm align-middle mb-0"><thead><tr><th>{{ __('Roll') }}</th><th>{{ __('Student ID') }}</th><th>{{ __('Name') }}</th><th>{{ __('Section') }}</th><th>{{ __('Status') }}</th><th>{{ __('Time') }}</th></tr></thead><tbody id="exam-attendance-rows">
                    @forelse($students as $student)<tr id="student-row-{{ $student->id }}"><td>{{ $student->roll }}</td><td>{{ $student->student_id }}</td><td>{{ $student->name }}</td><td>{{ $student->section?->name }}</td><td class="student-status">@if(($records[$student->id]->status ?? null) === 'present')<span class="badge bg-success">{{ __('Present') }}</span>@else<span class="badge bg-light text-muted">{{ __('Pending') }}</span>@endif</td><td class="student-time">{{ optional($records[$student->id] ?? null)->scanned_at?->format('h:i A') }}</td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-4">{{ __('No active students found.') }}</td></tr>@endforelse
                    </tbody></table></div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('customJs')
@if($examId && $classId)
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
const examScanUrl = @json(route('exam.attendance.record', ['tenant' => $tenant]));
const scanPayload = {exam_id: @json($examId), class_id: @json($classId), date: @json($date)};
let examScanner, examBusy = false;
async function submitExamScan(code) {
    if (examBusy || !code) return; examBusy = true;
    try { const response = await fetch(examScanUrl, {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'}, body:JSON.stringify({...scanPayload, qr_code_data:code.trim()})}); const data = await response.json();
        const msg = document.getElementById('exam-scan-message'); msg.className = 'small mt-3 ' + (data.success ? 'text-success' : 'text-danger'); msg.textContent = data.message || 'Scan failed';
        if (data.success && data.student) { const row = document.getElementById('student-row-'+data.student.id); if(row){row.querySelector('.student-status').innerHTML='<span class="badge bg-success">Present</span>'; row.querySelector('.student-time').textContent=data.student.time||'';} document.getElementById('present-count').textContent=data.present; }
    } catch(e) { document.getElementById('exam-scan-message').textContent = 'Unable to save attendance.'; } finally { setTimeout(()=>examBusy=false, 1200); }
}
document.getElementById('exam-manual-form').addEventListener('submit', e=>{e.preventDefault(); const input=document.getElementById('exam-manual-code'); submitExamScan(input.value); input.value='';});
if (window.Html5Qrcode) { examScanner = new Html5Qrcode('exam-qr-reader'); Html5Qrcode.getCameras().then(cameras=>{if(cameras.length) examScanner.start(cameras[cameras.length-1].id, {fps:10, qrbox:220}, submitExamScan, ()=>{});}).catch(()=>{}); }
</script>
@endif
@endsection
