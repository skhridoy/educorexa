@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center grid-margin mb-5">
        <div>
            <h4 class="fw-bold mb-0">Open New Support Ticket</h4>
            <p class="text-muted small">Submit your issue and our team will get back to you shortly.</p>
        </div>
        <a href="{{ route('school.support.index', ['tenant' => $tenant]) }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i data-feather="arrow-left"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('school.support.store', ['tenant' => $tenant]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-slate-700">Subject</label>
                                <input type="text" name="subject" class="form-control rounded-3 p-2 border-slate-200" placeholder="Briefly describe the issue" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-slate-700">Priority</label>
                                <select name="priority" class="form-select rounded-3 p-2 border-slate-200" required>
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-slate-700">Message</label>
                            <textarea name="message" class="form-control rounded-4 p-3 border-slate-200" rows="8" placeholder="Detailed explanation of your problem..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-slate-700">Attachment (Optional)</label>
                            <div class="p-3 border-dashed border-2 rounded-4 text-center bg-light">
                                <input type="file" name="attachment" id="attachment" class="d-none">
                                <label for="attachment" style="cursor: pointer;" class="mb-0">
                                    <i data-feather="upload-cloud" class="text-indigo mb-2" style="width:32px; height:32px;"></i>
                                    <p class="mb-1 fw-bold">Click to upload or drag and drop</p>
                                    <p class="text-muted small mb-0">PDF, PNG, JPG or DOCX (Max 5MB)</p>
                                    <div id="file-name-preview" class="mt-2 fw-bold text-indigo"></div>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid pt-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-indigo py-3">
                                <i data-feather="send" class="me-2"></i> Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        const attachmentInput = document.getElementById('attachment');
        const fileNamePreview = document.getElementById('file-name-preview');

        attachmentInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                fileNamePreview.textContent = "Selected: " + this.files[0].name;
            }
        });
    });
</script>
@endsection
