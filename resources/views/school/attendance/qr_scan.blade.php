@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ── Top Floating Toast Notification ── */
        .qr-toast-container {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 99999;
            width: 90%;
            max-width: 580px;
            pointer-events: none;
        }
        .qr-toast-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.18), 0 0 0 1px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 10px;
            animation: toastSlideDown 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            pointer-events: auto;
            border-left: 6px solid #10b981;
        }
        .qr-toast-card.toast-warning {
            border-left-color: #f59e0b;
        }
        .qr-toast-card.toast-error {
            border-left-color: #ef4444;
        }
        @keyframes toastSlideDown {
            from {
                opacity: 0;
                transform: translateY(-25px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .qr-toast-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            flex-shrink: 0;
        }
        .qr-toast-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .qr-toast-content {
            flex-grow: 1;
            min-width: 0;
        }
        .qr-toast-id {
            font-size: 11px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 2px;
        }
        .qr-toast-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.3;
        }
        .qr-toast-subtitle {
            font-size: 12px;
            color: #64748b;
            margin: 2px 0 0;
        }

        /* ── Scanner Viewfinder Card ── */
        .scanner-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
        .scanner-viewport-wrapper {
            position: relative;
            background: #0f172a;
            border-radius: 16px;
            overflow: hidden;
            min-height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #qr-reader {
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }
        #qr-reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 16px !important;
        }
        #qr-reader__scan_region {
            background: transparent !important;
        }
        #qr-reader__dashboard {
            display: none !important;
        }

        /* Scanning Laser Line */
        .scanner-laser-line {
            position: absolute;
            left: 5%;
            width: 90%;
            height: 3px;
            background: linear-gradient(90deg, rgba(79,70,229,0) 0%, #10b981 50%, rgba(79,70,229,0) 100%);
            box-shadow: 0 0 16px #10b981, 0 0 8px #10b981;
            z-index: 10;
            pointer-events: none;
            animation: laserScan 2.4s ease-in-out infinite alternate;
        }
        @keyframes laserScan {
            0% { top: 12%; opacity: 0.3; }
            50% { opacity: 1; }
            100% { top: 88%; opacity: 0.3; }
        }

        /* Viewfinder Frame Target Corners */
        .scanner-target-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 240px;
            height: 240px;
            pointer-events: none;
            z-index: 9;
            box-shadow: 0 0 0 9999px rgba(15, 23, 42, 0.45);
            border-radius: 20px;
        }
        .scanner-corner {
            position: absolute;
            width: 26px;
            height: 26px;
            border-color: #10b981;
            border-style: solid;
        }
        .corner-tl { top: -2px; left: -2px; border-width: 4px 0 0 4px; border-top-left-radius: 12px; }
        .corner-tr { top: -2px; right: -2px; border-width: 4px 4px 0 0; border-top-right-radius: 12px; }
        .corner-bl { bottom: -2px; left: -2px; border-width: 0 0 4px 4px; border-bottom-left-radius: 12px; }
        .corner-br { bottom: -2px; right: -2px; border-width: 0 4px 4px 0; border-bottom-right-radius: 12px; }

        /* ── Live Scanned Feed Table ── */
        .live-feed-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .live-feed-list {
            max-height: 520px;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .live-feed-item {
            padding: 12px 18px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: background .2s;
            animation: fadeInItem 0.4s ease-out;
        }
        .live-feed-item:hover {
            background: #fafbff;
        }
        @keyframes fadeInItem {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .live-feed-item:last-child {
            border-bottom: none;
        }
        .feed-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            flex-shrink: 0;
        }

        /* ── Stat Badges ── */
        .stat-card-qr {
            background: #ffffff;
            border-radius: 16px;
            padding: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(15,23,42,0.04);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* ── Mobile Tweaks ── */
        @media (max-width: 767.98px) {
            .scanner-target-box {
                width: 190px;
                height: 190px;
            }
            .scanner-viewport-wrapper {
                min-height: 260px;
            }
            .stat-card-qr {
                padding: 14px;
            }
            .stat-card-qr h3 {
                font-size: 20px !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ══ TOP FLOATING TOAST ALERT CONTAINER ══ --}}
    <div id="qr-toast-container" class="qr-toast-container"></div>

    {{-- ══ PAGE HEADER ══ --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="font-family:'Outfit', sans-serif;">
                <i class="fa-solid fa-qrcode text-primary me-2"></i> {{ __('ID Card QR Attendance') }}
            </h3>
            <p class="text-muted small mb-0">{{ __('Hold QR code in front of the camera for rapid automated attendance') }}</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="input-group input-group-sm" style="width: auto;">
                <span class="input-group-text bg-white"><i class="fa-regular fa-calendar-days text-primary"></i></span>
                <input type="date" id="attendance-date" class="form-control form-control-sm" value="{{ $today }}">
            </div>
            <a href="{{ route('attendances.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-list-check me-1"></i> {{ __('Manual Attendance') }}
            </a>
        </div>
    </div>

    {{-- ══ QUICK STATS ══ --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="stat-card-qr">
                <div style="width:48px;height:48px;border-radius:12px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;color:#10b981;font-size:22px;flex-shrink:0;">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div>
                    <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">{{ __('Total Present Today') }}</div>
                    <h3 class="fw-bold text-success mb-0" id="stat-present-count">{{ $presentCountToday }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="stat-card-qr">
                <div style="width:48px;height:48px;border-radius:12px;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#4f46e5;font-size:22px;flex-shrink:0;">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">{{ __('Total Students') }}</div>
                    <h3 class="fw-bold text-primary mb-0" id="stat-total-students">{{ $totalStudents }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-card-qr">
                <div style="width:48px;height:48px;border-radius:12px;background:#fffbeb;display:flex;align-items:center;justify-content:center;color:#f59e0b;font-size:22px;flex-shrink:0;">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <div>
                    <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">{{ __('Attendance Rate') }}</div>
                    <h3 class="fw-bold text-warning mb-0" id="stat-attendance-rate">{{ $attendanceRate }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- ══ LEFT COLUMN: CAMERA SCANNER & MANUAL BARCODE ══ --}}
        <div class="col-lg-6">
            <div class="scanner-card p-3 p-sm-4">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-soft-success text-success p-2 rounded-circle" id="scanner-live-badge" style="width:10px;height:10px;display:inline-block;padding:0 !important;background:#10b981;box-shadow:0 0 10px #10b981;"></span>
                        <h6 class="fw-bold mb-0 text-dark">{{ __('Camera Scanner') }}</h6>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="btn-toggle-sound" onclick="toggleSound()">
                            <i class="fa-solid fa-volume-high" id="sound-icon"></i> <span class="d-none d-sm-inline">{{ __('Sound Effect') }}</span>
                        </button>
                        <select id="camera-select" class="form-select form-select-sm rounded-pill" style="width: auto; min-width: 140px;" onchange="switchCamera(this.value)">
                            <option value="">{{ __('Loading Cameras...') }}</option>
                        </select>
                    </div>
                </div>

                {{-- Viewfinder --}}
                <div class="scanner-viewport-wrapper" id="scanner-viewport-wrapper">
                    <div id="qr-reader"></div>

                    {{-- Target Focus Frame --}}
                    <div class="scanner-target-box" id="scanner-target-box">
                        <div class="scanner-corner corner-tl"></div>
                        <div class="scanner-corner corner-tr"></div>
                        <div class="scanner-corner corner-bl"></div>
                        <div class="scanner-corner corner-br"></div>
                    </div>

                    {{-- Laser Scan Line --}}
                    <div class="scanner-laser-line" id="scanner-laser-line"></div>
                </div>

                {{-- Manual ID Input Form (For Barcode gun scanner or keyboard entry) --}}
                <div class="mt-4 pt-3 border-top">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-2">
                        <i class="fa-solid fa-barcode me-1 text-primary"></i> {{ __('Manual ID Entry') }} ({{ __('Supports Handheld Scanner') }})
                    </label>
                    <form id="manual-scan-form" onsubmit="handleManualScan(event)">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-id-card text-muted"></i></span>
                            <input type="text" id="manual-student-id" class="form-control" placeholder="{{ __('Enter Student ID (e.g. STD-26011001) & press Enter') }}" autocomplete="off">
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="fa-solid fa-check me-1"></i> {{ __('Submit ID') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ RIGHT COLUMN: LIVE SCANNED STREAM FEED ══ --}}
        <div class="col-lg-6">
            <div class="live-feed-card">
                <div class="p-3 p-sm-4 border-bottom d-flex align-items-center justify-content-between bg-light">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-stream text-primary me-2"></i>{{ __('Scanned Stream') }}
                        </h6>
                        <small class="text-muted">{{ __('Live Feed of marked students') }}</small>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3 py-2" id="feed-counter">
                        <span id="session-scan-count">0</span> {{ __('Scanned in Session') }}
                    </span>
                </div>

                <div class="live-feed-list p-2" id="live-feed-list">
                    {{-- Preloaded recent attendance logs --}}
                    @forelse($recentLogs as $log)
                    <div class="live-feed-item">
                        <img src="{{ $log->student && $log->student->photo ? asset($log->student->photo) : asset('assets/images/profile.webp') }}"
                             alt="{{ $log->student->name ?? 'Student' }}" class="feed-avatar">
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-soft-primary text-primary" style="font-size:10px;font-weight:700;">{{ $log->student->student_id ?? 'N/A' }}</span>
                                <span class="badge bg-soft-success text-success" style="font-size:10px;font-weight:700;">{{ __('Present') }}</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-0 mt-1" style="font-size:13.5px;">{{ $log->student->name ?? 'Unknown Student' }}</h6>
                            <div class="text-muted small" style="font-size:11.5px;">
                                {{ $log->student->class->name ?? 'Class' }} | {{ $log->student->section->name ?? 'Section' }} | {{ __('Roll') }}: {{ $log->student->roll ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="text-end text-muted small" style="font-size:11px;font-weight:600;">
                            <i class="fa-regular fa-clock me-1 text-primary"></i>{{ $log->created_at ? $log->created_at->format('h:i A') : 'Today' }}
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted" id="feed-empty-placeholder">
                        <div style="width:60px;height:60px;background:#f8fafc;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;border:1px dashed #cbd5e1;">
                            <i class="fa-solid fa-qrcode text-muted fs-3"></i>
                        </div>
                        <h6 class="text-muted fw-bold mb-1">{{ __('No students scanned yet in this session.') }}</h6>
                        <p class="small text-muted mb-0">{{ __('Hold student ID card in front of camera to mark attendance.') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('customJs')
{{-- Include HTML5 QR Code Library from CDN --}}
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrCode = null;
    let isProcessingScan = false;
    let soundEnabled = true;
    let sessionScannedCount = 0;
    let recentScanCache = {}; // Cooldown buffer per student ID
    const SCAN_COOLDOWN_MS = 2500; // 2.5s cooldown before scanning the exact same student again

    // ── Synthetic Web Audio Beep Chime ──
    function playBeepSound(isSuccess = true) {
        if (!soundEnabled) return;
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);

            if (isSuccess) {
                // High pleasant double chime (880Hz -> 1760Hz)
                osc.type = 'sine';
                osc.frequency.setValueAtTime(880, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(1760, ctx.currentTime + 0.12);
                gain.gain.setValueAtTime(0.3, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.25);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.25);
            } else {
                // Low buzz error tone (300Hz)
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(280, ctx.currentTime);
                gain.gain.setValueAtTime(0.2, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.3);
            }
        } catch (e) {
            console.log('Audio error:', e);
        }
    }

    function toggleSound() {
        soundEnabled = !soundEnabled;
        const icon = document.getElementById('sound-icon');
        if (soundEnabled) {
            icon.className = 'fa-solid fa-volume-high text-success';
        } else {
            icon.className = 'fa-solid fa-volume-xmark text-muted';
        }
    }

    // ── Toast Alert Banner at Top ──
    function showTopToast(data, type = 'success') {
        const container = document.getElementById('qr-toast-container');
        
        let badgeColor = type === 'success' ? 'background:#dcfce7;color:#15803d;' : (type === 'warning' ? 'background:#fef3c7;color:#b45309;' : 'background:#fee2e2;color:#b91c1c;');
        let toastClass = type === 'success' ? '' : (type === 'warning' ? 'toast-warning' : 'toast-error');

        let avatarHtml = '';
        if (data.student && data.student.photo) {
            avatarHtml = `<img src="${data.student.photo}" class="qr-toast-avatar" alt="Avatar">`;
        } else {
            let iconCode = type === 'success' ? 'fa-circle-check text-success' : (type === 'warning' ? 'fa-triangle-exclamation text-warning' : 'fa-circle-xmark text-danger');
            let iconBg = type === 'success' ? '#f0fdf4' : (type === 'warning' ? '#fffbeb' : '#fef2f2');
            avatarHtml = `<div class="qr-toast-icon" style="background:${iconBg};"><i class="fa-solid ${iconCode}"></i></div>`;
        }

        let studentId = data.student ? data.student.student_id : (data.student_id || 'N/A');
        let studentName = data.student ? data.student.name : 'Unknown';
        let studentInfo = data.student ? `${data.student.class_name} | ${data.student.section_name} | Roll: ${data.student.roll}` : '';

        const toastEl = document.createElement('div');
        toastEl.className = `qr-toast-card ${toastClass}`;
        toastEl.innerHTML = `
            ${avatarHtml}
            <div class="qr-toast-content">
                <span class="qr-toast-id" style="${badgeColor}">${studentId}</span>
                <h6 class="qr-toast-title">${studentName}</h6>
                <p class="qr-toast-subtitle">${data.message || ''} ${studentInfo ? '• ' + studentInfo : ''}</p>
            </div>
            <button type="button" class="btn-close" style="font-size:11px;" onclick="this.closest('.qr-toast-card').remove()"></button>
        `;

        container.prepend(toastEl);

        // Auto remove after 3.5 seconds
        setTimeout(() => {
            if (toastEl && toastEl.parentNode) {
                toastEl.style.transition = 'opacity 0.4s, transform 0.4s';
                toastEl.style.opacity = '0';
                toastEl.style.transform = 'translateY(-20px)';
                setTimeout(() => toastEl.remove(), 400);
            }
        }, 3500);
    }

    // ── Send QR Data to Server ──
    function sendAttendanceScan(qrData) {
        if (!qrData || isProcessingScan) return;

        const now = Date.now();
        // Check cooldown for this specific code
        if (recentScanCache[qrData] && (now - recentScanCache[qrData]) < SCAN_COOLDOWN_MS) {
            return; // Skip duplicate hits within cooldown window
        }
        recentScanCache[qrData] = now;

        isProcessingScan = true;
        const attendanceDate = document.getElementById('attendance-date').value;
        const tenant = "{{ auth()->user()->school->slug }}";
        const recordUrl = "{{ route('attendance.qr.record', ['tenant' => ':tenant']) }}".replace(':tenant', tenant);

        fetch(recordUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                qr_code_data: qrData,
                date: attendanceDate
            })
        })
        .then(res => res.json().then(data => ({ status: res.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 && body.success) {
                if (body.already_marked) {
                    playBeepSound(true);
                    showTopToast(body, 'warning');
                } else {
                    playBeepSound(true);
                    showTopToast(body, 'success');
                    prependToFeed(body.student);

                    sessionScannedCount++;
                    document.getElementById('session-scan-count').innerText = sessionScannedCount;
                }

                // Update Stats if returned
                if (body.stats) {
                    if (body.stats.today_present !== undefined) {
                        document.getElementById('stat-present-count').innerText = body.stats.today_present;
                    }
                    if (body.stats.attendance_rate !== undefined) {
                        document.getElementById('stat-attendance-rate').innerText = body.stats.attendance_rate + '%';
                    }
                }
            } else {
                playBeepSound(false);
                showTopToast({
                    student_id: body.student_id || qrData,
                    message: body.message || 'Student not found!'
                }, 'error');
            }
        })
        .catch(err => {
            console.error('Scan Error:', err);
            playBeepSound(false);
            showTopToast({ student_id: qrData, message: 'Server communication error!' }, 'error');
        })
        .finally(() => {
            setTimeout(() => {
                isProcessingScan = false;
            }, 300);
        });
    }

    // ── Prepend Scanned Student to Live Feed List ──
    function prependToFeed(student) {
        const list = document.getElementById('live-feed-list');
        const emptyPlaceholder = document.getElementById('feed-empty-placeholder');
        if (emptyPlaceholder) {
            emptyPlaceholder.remove();
        }

        const item = document.createElement('div');
        item.className = 'live-feed-item';
        item.innerHTML = `
            <img src="${student.photo}" alt="${student.name}" class="feed-avatar">
            <div class="flex-grow-1 min-width-0">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-soft-primary text-primary" style="font-size:10px;font-weight:700;">${student.student_id}</span>
                    <span class="badge bg-soft-success text-success" style="font-size:10px;font-weight:700;">{{ __('Present') }}</span>
                </div>
                <h6 class="fw-bold text-dark mb-0 mt-1" style="font-size:13.5px;">${student.name}</h6>
                <div class="text-muted small" style="font-size:11.5px;">
                    ${student.class_name} | ${student.section_name} | {{ __('Roll') }}: ${student.roll}
                </div>
            </div>
            <div class="text-end text-muted small" style="font-size:11px;font-weight:600;">
                <i class="fa-regular fa-clock me-1 text-primary"></i>${student.time || 'Just now'}
            </div>
        `;
        list.prepend(item);
    }

    // ── Manual Input / Barcode Gun Handler ──
    function handleManualScan(e) {
        e.preventDefault();
        const input = document.getElementById('manual-student-id');
        const val = input.value.trim();
        if (val) {
            sendAttendanceScan(val);
            input.value = '';
            input.focus();
        }
    }

    // ── HTML5 QR Scanner Initialization ──
    function initScanner(cameraId = null) {
        if (html5QrCode) {
            html5QrCode.stop().then(() => startScannerWithCamera(cameraId)).catch(() => startScannerWithCamera(cameraId));
        } else {
            html5QrCode = new Html5Qrcode("qr-reader");
            startScannerWithCamera(cameraId);
        }
    }

    function startScannerWithCamera(cameraId) {
        const config = {
            fps: 15,
            qrbox: { width: 220, height: 220 },
            aspectRatio: 1.0,
            showTorchButtonIfSupported: true
        };

        const cameraConfig = cameraId ? { deviceId: { exact: cameraId } } : { facingMode: "environment" };

        html5QrCode.start(
            cameraConfig,
            config,
            (decodedText, decodedResult) => {
                sendAttendanceScan(decodedText);
            },
            (errorMessage) => {
                // Ignore silent frame-by-frame read errors
            }
        ).catch(err => {
            console.error('Camera Start Error:', err);
        });
    }

    function switchCamera(cameraId) {
        if (cameraId) {
            initScanner(cameraId);
        }
    }

    // ── Load Cameras on Page Mount ──
    document.addEventListener("DOMContentLoaded", () => {
        Html5Qrcode.getCameras().then(devices => {
            const select = document.getElementById('camera-select');
            select.innerHTML = '';

            if (devices && devices.length) {
                devices.forEach((device, index) => {
                    const opt = document.createElement('option');
                    opt.value = device.id;
                    opt.text = device.label || `Camera ${index + 1}`;
                    select.appendChild(opt);
                });

                // Auto select back camera if found, else first
                let preferredCam = devices.find(d => d.label.toLowerCase().includes('back') || d.label.toLowerCase().includes('rear')) || devices[0];
                select.value = preferredCam.id;
                initScanner(preferredCam.id);
            } else {
                select.innerHTML = '<option value="">No Camera Found</option>';
            }
        }).catch(err => {
            console.warn('Cameras get error:', err);
            const select = document.getElementById('camera-select');
            select.innerHTML = '<option value="">Camera Blocked / Default</option>';
            initScanner();
        });
    });
</script>
@endsection
