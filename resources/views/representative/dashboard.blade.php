@extends('layouts.main')

@section('title', 'Representative Dashboard')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Greeting Logic --}}
        @php
            $hour = date('H');
            if ($hour >= 5 && $hour < 12)      { $greeting = "শুভ সকাল"; $faIcon = "fa-sun"; $greetColor = "#f59e0b"; }
            elseif ($hour >= 12 && $hour < 17) { $greeting = "শুভ দুপুর"; $faIcon = "fa-cloud-sun"; $greetColor = "#f97316"; }
            elseif ($hour >= 17 && $hour < 21) { $greeting = "শুভ বিকাল"; $faIcon = "fa-sunset"; $greetColor = "#8b5cf6"; }
            else                               { $greeting = "শুভ রাত্রি"; $faIcon = "fa-moon"; $greetColor = "#3b82f6"; }
        @endphp

        {{-- ===== HERO WELCOME CARD ===== --}}
        <div class="mb-5 p-4 p-md-5 position-relative overflow-hidden"
             style="border-radius:24px; background:linear-gradient(135deg, #0f2027, #203a43, #2c5364); color:white; box-shadow:0 15px 40px rgba(15,32,39,0.3);">

            {{-- Decorative Blobs --}}
            <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;background:rgba(99,102,241,0.15);border-radius:50%;filter:blur(40px);"></div>
            <div style="position:absolute;bottom:-40px;left:5%;width:160px;height:160px;background:rgba(16,185,129,0.1);border-radius:50%;filter:blur(30px);"></div>

            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:56px;height:56px;background:rgba(255,255,255,0.12);border-radius:16px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(10px);">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor }}"></i>
                        </div>
                        <div>
                            <div class="text-white opacity-60 small fw-semibold">{{ $greeting }}</div>
                            <h2 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif;letter-spacing:-0.02em;">
                                {{ $user->name }}
                            </h2>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="badge px-3 py-2" style="background:rgba(255,255,255,0.12);border-radius:10px;font-size:0.85rem;backdrop-filter:blur(8px);">
                            <i class="fa-solid fa-id-badge me-1"></i>{{ $employee->employee_id ?? 'N/A' }}
                        </span>
                        <span class="badge px-3 py-2" style="background:rgba(16,185,129,0.2);border-radius:10px;font-size:0.85rem;border:1px solid rgba(16,185,129,0.3);">
                            <i class="fa-solid fa-user-tie me-1 text-success"></i>Sales Representative
                        </span>
                        <span class="badge px-3 py-2" style="background:rgba(99,102,241,0.2);border-radius:10px;font-size:0.85rem;border:1px solid rgba(99,102,241,0.3);">
                            <i class="fa-solid fa-percent me-1" style="color:#818cf8;"></i>
                            কমিশন: {{ $employee->commission_label ?? '০.০০' }}
                            @if($employee && $employee->commission_type === 'percentage') % @endif
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <a href="{{ route('rep.school.register') }}" class="btn px-4 py-2 fw-semibold"
                       style="background:linear-gradient(135deg,#10b981,#059669);color:white;border-radius:14px;border:none;font-size:0.95rem;box-shadow:0 4px 15px rgba(16,185,129,0.35);">
                        <i class="fa-solid fa-plus me-2"></i>নতুন স্কুল নিবন্ধন
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== STATS ROW ===== --}}
        <div class="row g-4 mb-5">
            {{-- Total Schools --}}
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:20px;border-left:4px solid #6366f1 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:52px;height:52px;background:#eef2ff;border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-school fa-lg" style="color:#6366f1;"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold">মোট স্কুল</div>
                            <div class="h3 mb-0 fw-bold" style="color:#1e293b;">{{ $totalMySchools }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Approved Schools --}}
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:20px;border-left:4px solid #10b981 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:52px;height:52px;background:#ecfdf5;border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-circle-check fa-lg" style="color:#10b981;"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold">অনুমোদিত</div>
                            <div class="h3 mb-0 fw-bold" style="color:#1e293b;">{{ $approvedSchools }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Schools --}}
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:20px;border-left:4px solid #f59e0b !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:52px;height:52px;background:#fffbeb;border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-clock fa-lg" style="color:#f59e0b;"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold">অপেক্ষারত</div>
                            <div class="h3 mb-0 fw-bold" style="color:#1e293b;">{{ $pendingSchools }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Commission --}}
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:20px;border-left:4px solid #8b5cf6 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:52px;height:52px;background:#f5f3ff;border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-money-bill-trend-up fa-lg" style="color:#8b5cf6;"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-semibold">মোট কমিশন</div>
                            <div class="h3 mb-0 fw-bold" style="color:#1e293b;">৳{{ number_format($totalCommission, 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== MAIN CONTENT ROW ===== --}}
        <div class="row g-4">

            {{-- Recent Schools --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
                    <div class="px-4 py-3 bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #f1f5f9;">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="fa-solid fa-school me-2" style="color:#6366f1;"></i>আমার সাম্প্রতিক স্কুল
                        </h6>
                        <a href="{{ route('rep.schools.index') }}" class="btn btn-sm px-3 fw-semibold"
                           style="background:#eef2ff;color:#6366f1;border-radius:10px;font-size:0.82rem;">
                            সব দেখুন <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="p-4">
                        @forelse($mySchools as $school)
                        <div class="d-flex align-items-center gap-3 p-3 mb-2 rounded-3 rep-school-row"
                             style="background:#f8fafc;border:1px solid #f1f5f9;transition:all 0.2s;">
                            <div style="width:44px;height:44px;background:#eef2ff;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fa-solid fa-school" style="color:#6366f1;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark" style="font-size:0.95rem;">{{ $school->name ?? 'নাম নেই' }}</div>
                                <div class="text-muted small">{{ $school->district ?? '' }}{{ $school->district && $school->division ? ', ' : '' }}{{ $school->division ?? '' }}</div>
                            </div>
                            <div class="text-end">
                                @if($school->status === 'approved')
                                    <span class="badge px-2 py-1" style="background:#dcfce7;color:#16a34a;border-radius:8px;font-size:0.75rem;">অনুমোদিত</span>
                                @elseif($school->status === 'pending')
                                    <span class="badge px-2 py-1" style="background:#fef3c7;color:#d97706;border-radius:8px;font-size:0.75rem;">অপেক্ষারত</span>
                                @else
                                    <span class="badge px-2 py-1" style="background:#fee2e2;color:#dc2626;border-radius:8px;font-size:0.75rem;">বাতিল</span>
                                @endif
                                <div class="text-muted small mt-1" style="font-size:0.72rem;">{{ $school->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <div style="width:80px;height:80px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                                <i class="fa-solid fa-school fa-2x text-muted opacity-50"></i>
                            </div>
                            <p class="text-muted mb-3">এখনো কোনো স্কুল নিবন্ধন করা হয়নি।</p>
                            <a href="{{ route('rep.school.register') }}" class="btn btn-sm px-4 py-2"
                               style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;border-radius:12px;border:none;">
                                <i class="fa-solid fa-plus me-1"></i>প্রথম স্কুল নিবন্ধন করুন
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4">
                {{-- Commission Summary --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:20px;background:linear-gradient(135deg,#7c3aed,#6d28d9);color:white;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-coins fa-lg" style="color:#c4b5fd;"></i>
                        <h6 class="mb-0 fw-bold">কমিশন সারসংক্ষেপ</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3" style="background:rgba(255,255,255,0.1);">
                        <div class="small opacity-75">মোট কমিশন</div>
                        <div class="fw-bold fs-5">৳{{ number_format($totalCommission, 0) }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3" style="background:rgba(255,255,255,0.1);">
                        <div class="small opacity-75">এই মাসে</div>
                        <div class="fw-bold fs-5">৳{{ number_format($monthlyCommission, 0) }}</div>
                    </div>
                    <div class="mb-3 p-3 rounded-3" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);">
                        <div class="small opacity-75 mb-1">আপনার কমিশন রেট</div>
                        <div class="fw-bold">
                            @if($employee && $employee->commission_type === 'percentage')
                                {{ $employee->commission_rate }}% (সাবস্ক্রিপশনের উপর)
                            @elseif($employee)
                                ৳{{ number_format($employee->commission_rate, 0) }} (প্রতি স্কুলে)
                            @else
                                নির্ধারিত হয়নি
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('rep.commissions') }}" class="btn w-100 fw-semibold py-2"
                       style="background:rgba(255,255,255,0.15);color:white;border:1px solid rgba(255,255,255,0.3);border-radius:12px;">
                        <i class="fa-solid fa-chart-line me-2"></i>বিস্তারিত কমিশন
                    </a>
                </div>

                {{-- Quick Actions --}}
                <div class="card border-0 shadow-sm p-4" style="border-radius:20px;">
                    <h6 class="fw-bold mb-4 text-dark">
                        <i class="fa-solid fa-bolt me-2" style="color:#f59e0b;"></i>দ্রুত কাজ
                    </h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('rep.school.register') }}" class="btn py-3 text-start px-3 fw-semibold"
                           style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;border-radius:14px;">
                            <i class="fa-solid fa-school-circle-check me-2"></i>নতুন স্কুল নিবন্ধন
                        </a>
                        <a href="{{ route('rep.schools.index') }}" class="btn py-3 text-start px-3 fw-semibold"
                           style="background:#eef2ff;color:#6366f1;border:1px solid #c7d2fe;border-radius:14px;">
                            <i class="fa-solid fa-list-check me-2"></i>আমার স্কুলসমূহ
                        </a>
                        <a href="{{ route('rep.commissions') }}" class="btn py-3 text-start px-3 fw-semibold"
                           style="background:#f5f3ff;color:#7c3aed;border:1px solid #ddd6fe;border-radius:14px;">
                            <i class="fa-solid fa-file-invoice-dollar me-2"></i>কমিশন রিপোর্ট
                        </a>
                        <a href="{{ route('profile') }}" class="btn py-3 text-start px-3 fw-semibold"
                           style="background:#f8fafc;color:#475569;border:1px solid #e2e8f0;border-radius:14px;">
                            <i class="fa-solid fa-user-circle me-2"></i>আমার প্রোফাইল
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<style>
.rep-school-row:hover {
    background:#eef2ff !important;
    border-color:#c7d2fe !important;
    transform: translateX(4px);
}
</style>
@endsection
