@extends('layouts.main')

@section('title', 'কমিশন রিপোর্ট')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark" style="font-family:'Outfit',sans-serif;">
                    <i class="fa-solid fa-money-bill-trend-up me-2" style="color:#7c3aed;"></i>কমিশন হিসাব ও উপার্জনের বিবরণী
                </h4>
                <p class="text-muted small mb-0">আপনার রেফারেন্সে নিবন্ধিত স্কুল থেকে প্রাপ্ত কমিশনের পূর্ণাঙ্গ হিসাব</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('rep.dashboard') }}" class="btn px-3 py-2 fw-semibold"
                   style="background:#f1f5f9;color:#475569;border-radius:12px;border:none;">
                    <i class="fa-solid fa-arrow-left me-1"></i>ড্যাশবোর্ড
                </a>
                <a href="{{ route('rep.schools.index') }}" class="btn px-3 py-2 fw-semibold"
                   style="background:#eef2ff;color:#6366f1;border-radius:12px;border:none;">
                    <i class="fa-solid fa-school me-1"></i>আমার স্কুলসমূহ
                </a>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100"
                     style="border-radius:20px;background:linear-gradient(135deg,#7c3aed,#6d28d9);color:white;">
                    <div class="h2 fw-bold mb-1 text-white">৳{{ number_format($totalCommission, 0) }}</div>
                    <div class="small opacity-80">সর্বমোট কমিশন (All Time)</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100"
                     style="border-radius:20px;background:linear-gradient(135deg,#4f46e5,#4338ca);color:white;">
                    <div class="h2 fw-bold mb-1 text-white">৳{{ number_format($totalRegCommission, 0) }}</div>
                    <div class="small opacity-80">মোট রেজিস্ট্রেশন কমিশন</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100"
                     style="border-radius:20px;background:linear-gradient(135deg,#059669,#047857);color:white;">
                    <div class="h2 fw-bold mb-1 text-white">৳{{ number_format($totalMonthlyCommission, 0) }}</div>
                    <div class="small opacity-80">মোট মাসিক রিকারিং কমিশন</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100"
                     style="border-radius:20px;background:linear-gradient(135deg,#0284c7,#0369a1);color:white;">
                    <div class="h2 fw-bold mb-1 text-white">৳{{ number_format($monthlyCommission, 0) }}</div>
                    <div class="small opacity-80">চলতি মাসের কমিশন (This Month)</div>
                </div>
            </div>
        </div>

        {{-- Commission Rate & Calculation Info Banner --}}
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:20px;background:linear-gradient(135deg,#f5f3ff,#ede9fe);border-left:5px solid #7c3aed !important;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:52px;height:52px;background:#7c3aed;border-radius:16px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-handshake fa-lg text-white"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark fs-6">আপনার নির্ধারিত ২-ধাপ কমিশন পলিসি</div>
                            <div class="text-muted small mt-1">
                                <div><strong style="color:#4f46e5;">১. নতুন স্কুল রেজিস্ট্রেশন কমিশন:</strong> প্যাকেজ অনুসারে এককালীন (ডিফল্ট: {{ $employee->commission_label }})</div>
                                <div><strong style="color:#059669;">২. প্রতি মাসের এক্সট্রা কমিশন:</strong> সক্রিয় স্কুলের জন্য প্রতি মাসে রিকারিং (ডিফল্ট: {{ ($employee->monthly_commission_rate ?? 0) > 0 ? ($employee->monthly_commission_type === 'percentage' ? $employee->monthly_commission_rate.'%' : '৳'.number_format($employee->monthly_commission_rate, 0)) : 'প্যাকেজ রেট' }})</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-flex flex-column align-items-end gap-1">
                        <span class="badge px-3 py-2" style="background:#4f46e5;color:white;border-radius:10px;font-size:0.8rem;">
                            <i class="fa-solid fa-tag me-1"></i>রেজি: {{ $employee->commission_label }}
                        </span>
                        <span class="badge px-3 py-2" style="background:#059669;color:white;border-radius:10px;font-size:0.8rem;">
                            <i class="fa-solid fa-rotate me-1"></i>মাসিক: {{ ($employee->monthly_commission_rate ?? 0) > 0 ? ($employee->monthly_commission_type === 'percentage' ? $employee->monthly_commission_rate.'%' : '৳'.number_format($employee->monthly_commission_rate, 0)) : 'প্যাকেজ রেট' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- School-wise Commission Table --}}
        <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
            <div class="px-4 py-3 bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #f1f5f9;">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-list me-2 text-primary"></i>স্কুল-ভিত্তিক অর্জিত কমিশনের বিবরণ
                </h6>
                <span class="text-muted small">মোট স্কুল: {{ $schoolsWithCommission->count() }}টি</span>
            </div>
            <div class="p-0">
                @if($schoolsWithCommission->isEmpty())
                <div class="text-center py-5">
                    <div style="width:80px;height:80px;background:#f8fafc;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <i class="fa-solid fa-coins fa-2x text-muted opacity-40"></i>
                    </div>
                    <h6 class="text-muted fw-semibold">কোনো কমিশন রেকর্ড নেই</h6>
                    <p class="text-muted small">স্কুল নিবন্ধনের পর সাবস্ক্রিপশন পরিশোধিত হলে কমিশন অর্জিত হবে</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.92rem;">
                        <thead>
                            <tr style="background:#f8fafc;color:#64748b;font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">
                                <th class="px-4 py-3 border-0">স্কুল ও কোড</th>
                                <th class="py-3 border-0">প্যাকেজ</th>
                                <th class="py-3 border-0">স্কুল স্ট্যাটাস</th>
                                <th class="py-3 border-0">সাবস্ক্রিপশন</th>
                                <th class="py-3 border-0 text-end" style="color:#4f46e5;">রেজিস্ট্রেশন কমিশন</th>
                                <th class="py-3 border-0 text-end" style="color:#059669;">মাসিক কমিশন</th>
                                <th class="py-3 border-0 text-end" style="color:#7c3aed;">সর্বমোট কমিশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schoolsWithCommission as $school)
                            <tr style="border-bottom:1px solid #f8fafc;">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:40px;height:40px;background:#eef2ff;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            @if($school->logo)
                                                <img src="{{ asset($school->logo) }}" style="width:34px;height:34px;object-fit:contain;border-radius:8px;">
                                            @else
                                                <i class="fa-solid fa-school" style="color:#6366f1;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $school->name ?? '—' }}</div>
                                            <div class="text-muted small" style="font-size:0.75rem;">
                                                <code>{{ $school->app_code ?? 'N/A' }}</code>
                                                @if($school->district) &bull; {{ $school->district }} @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge px-3 py-2" style="background:#f0f9ff;color:#0369a1;border-radius:10px;font-size:0.78rem;">
                                        {{ $school->subscriptionPackage?->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if($school->status === 'approved')
                                        <span class="badge px-2 py-1" style="background:#ecfdf5;color:#065f46;border-radius:8px;font-size:0.75rem;">
                                            <i class="fa-solid fa-circle-check me-1"></i>অনুমোদিত
                                        </span>
                                    @elseif($school->status === 'pending')
                                        <span class="badge px-2 py-1" style="background:#fffbeb;color:#92400e;border-radius:8px;font-size:0.75rem;">
                                            <i class="fa-solid fa-clock me-1"></i>পেন্ডিং
                                        </span>
                                    @else
                                        <span class="badge px-2 py-1" style="background:#fef2f2;color:#991b1b;border-radius:8px;font-size:0.75rem;">
                                            <i class="fa-solid fa-circle-xmark me-1"></i>বাতিল
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <span class="fw-bold text-dark">{{ $school->subscriptions->count() }}</span>
                                    <span class="text-muted small ms-1">টি পেইড</span>
                                </td>
                                <td class="py-3 text-end">
                                    <span class="fw-bold" style="color:#4f46e5;">
                                        ৳{{ number_format($school->registration_commission ?? 0, 2) }}
                                    </span>
                                </td>
                                <td class="py-3 text-end">
                                    <span class="fw-bold" style="color:#059669;">
                                        ৳{{ number_format($school->monthly_commission ?? 0, 2) }}
                                    </span>
                                </td>
                                <td class="py-3 text-end">
                                    <span class="fw-bold" style="color:#7c3aed;font-size:1.05rem;">
                                        ৳{{ number_format($school->earned_commission, 2) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:#f5f3ff;border-top:2px solid #ddd6fe;">
                                <td colspan="4" class="px-4 py-3 fw-bold text-dark fs-6">
                                    <i class="fa-solid fa-coins me-2 text-warning"></i>মোট অর্জিত কমিশন
                                </td>
                                <td class="py-3 text-end fw-bold" style="color:#4f46e5;font-size:1.05rem;">
                                    ৳{{ number_format($totalRegCommission, 2) }}
                                </td>
                                <td class="py-3 text-end fw-bold" style="color:#059669;font-size:1.05rem;">
                                    ৳{{ number_format($totalMonthlyCommission, 2) }}
                                </td>
                                <td class="py-3 text-end fw-bold" style="color:#7c3aed;font-size:1.15rem;">
                                    ৳{{ number_format($totalCommission, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
