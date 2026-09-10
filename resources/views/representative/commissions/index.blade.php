@extends('layouts.main')

@section('title', 'কমিশন রিপোর্ট')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color:#1e293b;">
                    <i class="fa-solid fa-money-bill-trend-up me-2" style="color:#7c3aed;"></i>কমিশন রিপোর্ট
                </h4>
                <p class="text-muted small mb-0">আপনার নিবন্ধিত স্কুল থেকে অর্জিত কমিশনের বিস্তারিত</p>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 text-center" style="border-radius:20px;background:linear-gradient(135deg,#7c3aed,#6d28d9);color:white;">
                    <div class="h2 fw-bold mb-1">৳{{ number_format($totalCommission, 0) }}</div>
                    <div class="small opacity-75">মোট কমিশন</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 text-center" style="border-radius:20px;background:linear-gradient(135deg,#059669,#047857);color:white;">
                    <div class="h2 fw-bold mb-1">৳{{ number_format($monthlyCommission, 0) }}</div>
                    <div class="small opacity-75">এই মাসে</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 text-center" style="border-radius:20px;">
                    <div class="h2 fw-bold mb-1" style="color:#6366f1;">{{ $totalSchools }}</div>
                    <div class="text-muted small">মোট স্কুল</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-4 text-center" style="border-radius:20px;">
                    <div class="h2 fw-bold mb-1" style="color:#10b981;">{{ $approvedSchools }}</div>
                    <div class="text-muted small">অনুমোদিত স্কুল</div>
                </div>
            </div>
        </div>

        {{-- Commission Rate Info --}}
        <div class="card border-0 p-4 mb-4" style="border-radius:20px;background:linear-gradient(135deg,#f5f3ff,#ede9fe);">
            <div class="d-flex align-items-center gap-3">
                <div style="width:52px;height:52px;background:#7c3aed;border-radius:14px;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-percent fa-lg text-white"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark">আপনার কমিশন রেট</div>
                    <div class="text-muted small">
                        @if($employee->commission_type === 'percentage')
                            <strong style="color:#7c3aed;">{{ $employee->commission_rate }}%</strong> — প্রতিটি স্কুলের active subscription amount-এর উপর
                        @else
                            <strong style="color:#7c3aed;">৳{{ number_format($employee->commission_rate, 0) }}</strong> — প্রতিটি active subscription-এ flat amount
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- School-wise Commission Table --}}
        <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
            <div class="px-4 py-3" style="border-bottom:1px solid #f1f5f9;">
                <h6 class="mb-0 fw-bold text-dark">স্কুল-ভিত্তিক কমিশন বিবরণ</h6>
            </div>
            <div class="p-0">
                @if($schoolsWithCommission->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-coins fa-3x text-muted opacity-30 mb-3"></i>
                    <p class="text-muted">এখনো কোনো স্কুল নিবন্ধন করা হয়নি।</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.92rem;">
                        <thead>
                            <tr style="background:#f8fafc;color:#64748b;font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">
                                <th class="px-4 py-3 border-0">স্কুল</th>
                                <th class="py-3 border-0">প্যাকেজ</th>
                                <th class="py-3 border-0">স্ট্যাটাস</th>
                                <th class="py-3 border-0">সক্রিয় সাবস্ক্রিপশন</th>
                                <th class="py-3 border-0 text-end">অর্জিত কমিশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schoolsWithCommission as $school)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="px-4 py-3">
                                    <div class="fw-semibold text-dark">{{ $school->name ?? '—' }}</div>
                                    <div class="text-muted small">{{ $school->app_code ?? '' }}</div>
                                </td>
                                <td class="py-3">
                                    <span class="badge px-2 py-1" style="background:#f0f9ff;color:#0369a1;border-radius:8px;font-size:0.78rem;">
                                        {{ $school->subscriptionPackage?->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if($school->status === 'approved')
                                        <span class="badge px-2 py-1" style="background:#ecfdf5;color:#065f46;border-radius:8px;font-size:0.75rem;">অনুমোদিত</span>
                                    @elseif($school->status === 'pending')
                                        <span class="badge px-2 py-1" style="background:#fffbeb;color:#92400e;border-radius:8px;font-size:0.75rem;">পেন্ডিং</span>
                                    @else
                                        <span class="badge px-2 py-1" style="background:#fef2f2;color:#991b1b;border-radius:8px;font-size:0.75rem;">বাতিল</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <span class="fw-semibold" style="color:#6366f1;">{{ $school->subscriptions->count() }}</span>
                                    <span class="text-muted small ms-1">টি সাবস্ক্রিপশন</span>
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
                            <tr style="background:#f5f3ff;">
                                <td colspan="4" class="px-4 py-3 fw-bold text-dark">মোট কমিশন</td>
                                <td class="py-3 text-end fw-bold" style="color:#7c3aed;font-size:1.1rem;">
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
