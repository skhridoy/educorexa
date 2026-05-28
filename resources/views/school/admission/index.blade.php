@extends('layouts.school')

@section('customCSS')
<style>
/* Modern card and table styling */
.admission-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08);
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}
.admission-card .card-header {
    background: linear-gradient(90deg, #6571ff, #6c5dd3);
    color: #fff;
    font-weight: 600;
    font-size: 1.25rem;
    padding: 1rem 1.5rem;
}
.admission-table th {
    background: #f1f3f5;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}
.admission-table td, .admission-table th {
    vertical-align: middle;
    text-align: center;
    padding: 0.75rem;
}
.admission-table img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.btn-primary {
    background: linear-gradient(45deg, #6571ff, #6c5dd3);
    border: none;
    transition: transform 0.2s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="admission-card">
        <div class="card-header text-center my-3">
            <i class="bi bi-clipboard-data"></i> Online Admissions Overview
        </div>
        <div class="card-body">
            <div class="row g-4">
                @foreach($admissions as $admission)
                <div class="col-md-4">
                    <div class="card h-100 border-0" style="background-color: #f3f4f6; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        <div class="card-header border-0 d-flex align-items-center" style="background: linear-gradient(135deg, #5b73e8, #7451d6); padding: 15px 20px;">
                            <img src="{{ $admission->photo ? asset($admission->photo) : asset('images/avatar.png') }}" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
                            <h5 class="mb-0 text-white fw-bold" style="letter-spacing: 0.5px;">#{{ $admission->admission_number }}</h5>
                        </div>
                        <div class="card-body" style="padding: 20px; color: #374151;">
                            <p class="mb-2"><strong style="color: #111827;">Name:</strong> {{ $admission->name }}</p>
                            <p class="mb-2"><strong style="color: #111827;">Year:</strong> {{ $admission->academicYear->name ?? 'N/A' }}</p>
                            <p class="mb-2"><strong style="color: #111827;">Class:</strong> {{ $admission->class->name ?? 'N/A' }}</p>
                            <p class="mb-2"><strong style="color: #111827;">Section:</strong> {{ $admission->section->name ?? 'N/A' }}</p>
                            <p class="mb-2"><strong style="color: #111827;">Contact:</strong> {{ $admission->contact_number }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-top d-flex justify-content-between align-items-center" style="padding: 15px 20px; border-color: #e5e7eb !important;">
                            @if($admission->status == 'pending')
                            <form action="{{ route('admissions.approve', ['tenant' => auth()->user()->school->slug, 'admission' => $admission->id]) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm text-white border-0" style="background-color: #10b981; border-radius: 20px; padding: 5px 15px; font-size: 12px; font-weight:600; box-shadow: 0 2px 4px rgba(16,185,129,0.3);">Approve</button>
                            </form>
                            @endif
                            <form action="{{ route('admissions.reject', ['tenant' => auth()->user()->school->slug, 'admission' => $admission->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm text-white border-0" onclick="confirmDelete(this)" style="background-color: #ef4444; border-radius: 20px; padding: 5px 15px; font-size: 12px; font-weight:600; box-shadow: 0 2px 4px rgba(239,68,68,0.3);">Reject</button>
                            </form>
                            <a href="{{ route('admissions.pdf', $admission->id) }}" class="btn btn-sm text-white border-0" style="background-color: #6366f1; border-radius: 20px; padding: 5px 15px; font-size: 12px; font-weight:600; box-shadow: 0 2px 4px rgba(99,102,241,0.3);">PDF</a>
                        </div>
                    </div>
                </div>
                @endforeach
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
            text: "Do you want to reject this student?",
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