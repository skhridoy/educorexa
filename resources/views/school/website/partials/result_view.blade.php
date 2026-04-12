

<style>
    /* Global background for this page */
    body {
        background-color: #f8f9fa !important;
    }

    /* Pulls the card slightly into the hero header for a modern look */
    .result-section {
        padding-bottom: 60px;
        margin-top: -80px; 
        position: relative;
        z-index: 5;
    }

    .transition {
        transition: all 0.3s ease;
    }

    .transition:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }

    .result-container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        border-radius: 25px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    /* Gradient Header */
    .result-header {
        background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
        padding: 40px 20px;
        color: white;
        text-align: center;
    }

    .profile-avatar {
        width: 110px;
        height: 110px;
        background: #fff;
        border-radius: 50%;
        margin: 0 auto 15px;
        padding: 5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Status Badge */
    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        margin-top: 20px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .bg-status-fail { background: #ff4757 !important; border: none; }
    .bg-status-pass { background: #2ed573 !important; border: none; }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1px solid #f0f0f0;
    }

    .stat-box {
        padding: 25px 10px;
        text-align: center;
        border-right: 1px solid #f0f0f0;
    }

    .stat-box:last-child { border-right: none; }

    .stat-label {
        font-size: 11px;
        color: #95a5a6;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 5px;
        display: block;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #2c3e50;
    }
#spinner {
    opacity: 0;
    visibility: hidden;
    transition: opacity .5s ease-out, visibility 0s linear .5s;
    z-index: 99999;
    pointer-events: none; 
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
}

#spinner.show {
    transition: opacity .5s ease-out, visibility 0s linear 0s;
    visibility: visible;
    opacity: 1;
    pointer-events: all; /* Blocks clicks ONLY when visible */
}

/* Ensure the modal content doesn't have a margin-top that hides the header */
.modal-body .result-section {
    margin-top: 0 !important;
    padding-bottom: 20px;
}
    .exam-details {
        background: #f1f7ff;
        margin: 20px;
        padding: 20px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        border: 1px solid #e2efff;
    }

    /* Responsiveness */
    @media (max-width: 576px) {
        .result-section { margin-top: -50px; padding: 0 15px 30px; }
        .stat-val { font-size: 18px; }
        .stat-label { font-size: 9px; }
        .result-header h3 { font-size: 1.4rem; }
    }
</style>


<div class="result-section">
    <div class="result-container position-relative">
        
        {{-- Optional: Close button inside the card for mobile users --}}
        

        {{-- Top Card Header --}}
        <div class="result-header">
            <div class="profile-avatar">
                <img src="{{ $student->photo ? asset('storage/' . $student->photo) : asset('assets/images/profile.webp') }}" 
                     alt="{{ $student->name }}"
                     onerror="this.src='{{ asset('assets/images/profile.webp') }}'">
            </div>
            <h3 class="fw-bold mb-1 text-white">{{ $student->name }}</h3>
            <div class="small text-white opacity-90">
                <i class="fas fa-id-card me-1"></i> ID: <strong>{{ $student->student_id }}</strong> | 
                <i class="fas fa-graduation-cap me-1"></i> Class: <strong>{{ $student->class->name }}</strong>
            </div>

            @php $isFailed = ($studentSummary['fail'] ?? 0) > 0; @endphp
            <div class="status-pill {{ $isFailed ? 'bg-status-fail' : 'bg-status-pass' }}">
                <i class="fas {{ $isFailed ? 'fa-times-circle' : 'fa-check-circle' }} me-2"></i>
                {{ $isFailed ? "RESULT: FAILED ({$studentSummary['fail']} SUBJECTS)" : 'RESULT: PASSED' }}
            </div>
        </div>

        {{-- Result Stats --}}
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-label">Grade Point</span>
                <span class="stat-val {{ $isFailed ? 'text-danger' : 'text-success' }}">
                    {{ number_format($studentSummary['gpa'] ?? 0, 2) }}
                </span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Total Marks</span>
                <span class="stat-val">{{ $studentSummary['total'] ?? 0 }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Position</span>
                <span class="stat-val text-primary">#{{ $meritPosition ?? 'N/A' }}</span>
            </div>
        </div>

        {{-- Exam Info --}}
        <div class="exam-details">
            <div class="bg-white p-2 rounded-3 shadow-sm me-3 text-primary">
                <i class="fas fa-calendar-alt fa-lg"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark">{{ $exam->name }}</h6>
                <small class="text-muted">Academic Session: {{ $student->academicYear->name }}</small>
            </div>
        </div>

        {{-- Action Button --}}
        <div class="p-4 pt-0">
            <a href="{{ route('frontend.generate_marksheet', ['tenant' => $tenant, 'studentId' => $student->id, 'classId' => $student->class_id, 'examId' => $exam->id]) }}" 
               class="btn btn-primary btn-lg w-100 rounded-pill fw-bold py-3 shadow-sm transition">
                <i class="fas fa-file-download me-2"></i> Download Marksheet (PDF)
            </a>
        </div>
    </div>
</div>

<script>
$(document).on('click', '.btn-close', function() {
    $('#resultModal').modal('hide');
    // Force remove backdrop if it gets stuck
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('overflow', 'auto');
});
</script>
