@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1" style="font-family:'Outfit',sans-serif; color:#1e293b;">Add New Event</h3>
                <p class="text-muted mb-0" style="font-size:0.9rem;">Create a platform-level activity or announcement.</p>
            </div>
            <a href="{{ route('super.events.index') }}" class="btn-edu btn-edu-light">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="edu-panel border-0 shadow-sm p-4">
                    <form action="{{ route('super.events.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small">Event Title</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Science Fair 2026" required
                                       style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Event Date</label>
                                <input type="date" name="event_date" class="form-control" required
                                       style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Event Time (Optional)</label>
                                <input type="time" name="event_time" class="form-control"
                                       style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small">Location</label>
                                <input type="text" name="location" class="form-control" placeholder="e.g. Main Auditorium"
                                       style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small">Description (Optional)</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe the event..."
                                          style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small mb-3">Theme Color</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check custom-option">
                                        <input class="form-check-input d-none" type="radio" name="color" value="blue" id="colorBlue" checked>
                                        <label class="form-check-label border p-3 rounded-3 d-flex align-items-center gap-2 cursor-pointer" for="colorBlue" style="cursor:pointer;">
                                            <div style="width:16px;height:16px;border-radius:4px;background:#3b82f6;"></div> Blue
                                        </label>
                                    </div>
                                    <div class="form-check custom-option">
                                        <input class="form-check-input d-none" type="radio" name="color" value="purple" id="colorPurple">
                                        <label class="form-check-label border p-3 rounded-3 d-flex align-items-center gap-2 cursor-pointer" for="colorPurple" style="cursor:pointer;">
                                            <div style="width:16px;height:16px;border-radius:4px;background:#8b5cf6;"></div> Purple
                                        </label>
                                    </div>
                                    <div class="form-check custom-option">
                                        <input class="form-check-input d-none" type="radio" name="color" value="green" id="colorGreen">
                                        <label class="form-check-label border p-3 rounded-3 d-flex align-items-center gap-2 cursor-pointer" for="colorGreen" style="cursor:pointer;">
                                            <div style="width:16px;height:16px;border-radius:4px;background:#22c55e;"></div> Green
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn-edu btn-edu-light">Reset Form</button>
                                    <button type="submit" class="btn-edu btn-edu-primary px-5">Save Event</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .custom-option input:checked + label {
        border-color: #4f46e5 !important;
        background: #f5f3ff !important;
        box-shadow: 0 0 0 1px #4f46e5;
    }
</style>
@endsection
