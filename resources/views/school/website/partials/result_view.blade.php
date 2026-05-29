<style>
    /* Scoped styling to avoid global conflicts */
    .res-section {
        padding: 0;
        position: relative;
    }

    .res-container {
        width: 100%;
        margin: 0 auto;
        overflow: hidden;
        background: transparent;
    }

    /* Gradient Header matching the branding */
    .res-header {
        background: linear-gradient(135deg, #002147 0%, #003366 100%);
        padding: 30px 20px;
        color: white;
        text-align: center;
        border-radius: 15px;
        margin-bottom: 25px;
    }

    .res-avatar {
        width: 90px;
        height: 90px;
        background: #ffffff;
        border-radius: 50%;
        margin: 0 auto 15px;
        padding: 4px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .res-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Status Badge */
    .res-status-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 12px;
        margin-top: 15px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(5px);
        color: #ffffff;
        border: 1px solid rgba(255,255,255,0.25);
    }

    .res-bg-fail { 
        background: #ef4444 !important; 
        border: none; 
    }
    .res-bg-pass { 
        background: #10b981 !important; 
        border: none; 
    }

    /* Stats Grid */
    .res-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .res-stat-box {
        padding: 15px 10px;
        text-align: center;
        border-right: 1px solid #e2e8f0;
    }

    .res-stat-box:last-child { 
        border-right: none; 
    }

    .res-stat-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        margin-bottom: 5px;
        display: block;
    }

    .res-stat-val {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
    }

    .res-exam-details {
        background: #f0f7ff;
        padding: 15px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        border: 1px solid #e0efff;
        margin-bottom: 25px;
    }

    .res-icon-wrap {
        background: #ffffff;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        margin-right: 15px;
        color: #002147;
    }

    .res-action-btn {
        background: #F9B800;
        color: #002147;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        padding: 12px;
        display: block;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(249,184,0,0.1);
    }

    .res-action-btn:hover {
        background: #e0a500;
        color: #002147;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(249,184,0,0.2);
    }
</style>

<div class="res-section animate__animated animate__fadeIn">
    <div class="res-container">
        
        {{-- Top Card Header --}}
        <div class="res-header">
            <div class="res-avatar">
                <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}" 
                     alt="{{ $student->name }}"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=002147&color=fff'">
            </div>
            <h4 class="fw-bold mb-1 text-white" style="font-family: 'Outfit', sans-serif;">{{ $student->name }}</h4>
            <div class="small text-white-50">
                <i class="fas fa-id-card me-1"></i> ID: <strong>{{ $student->student_id }}</strong> | 
                <i class="fas fa-graduation-cap me-1"></i> Class: <strong>{{ $student->class->name }}</strong>
            </div>

            @php $isFailed = ($studentSummary['fail'] ?? 0) > 0; @endphp
            <div class="res-status-pill {{ $isFailed ? 'res-bg-fail' : 'res-bg-pass' }}">
                <i class="fas {{ $isFailed ? 'fa-times-circle' : 'fa-check-circle' }} me-2"></i>
                {{ $isFailed ? "RESULT: FAILED ({$studentSummary['fail']} SUBJECTS)" : 'RESULT: PASSED' }}
            </div>
        </div>

        {{-- Result Stats --}}
        <div class="res-stats-grid">
            <div class="res-stat-box">
                <span class="res-stat-label">Grade Point</span>
                <span class="res-stat-val {{ $isFailed ? 'text-danger' : 'text-success' }}">
                    {{ number_format($studentSummary['gpa'] ?? 0, 2) }}
                </span>
            </div>
            <div class="res-stat-box">
                <span class="res-stat-label">Total Marks</span>
                <span class="res-stat-val">{{ $studentSummary['total'] ?? 0 }}</span>
            </div>
            <div class="res-stat-box">
                <span class="res-stat-label">Position</span>
                <span class="res-stat-val text-primary">#{{ $meritPosition ?? 'N/A' }}</span>
            </div>
        </div>

        {{-- Exam Info --}}
        <div class="res-exam-details">
            <div class="res-icon-wrap">
                <i class="fas fa-calendar-alt fa-lg"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark" style="font-size: 14px;">{{ $exam->name }}</h6>
                <small class="text-muted" style="font-size: 12px;">Academic Session: {{ $student->academicYear->name }}</small>
            </div>
        </div>

        {{-- Action Button --}}
        <div>
            <a href="{{ route('frontend.generate_marksheet', ['tenant' => $tenant, 'studentId' => $student->id, 'classId' => $student->class_id, 'examId' => $exam->id]) }}" 
               class="res-action-btn w-100">
                <i class="fas fa-file-download me-2"></i> Download Marksheet (PDF)
            </a>
        </div>
    </div>
</div>
