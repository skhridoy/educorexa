@extends('layouts.main')

@section('title', 'আমার নিবন্ধিত স্কুলসমূহ')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark" style="font-family:'Outfit',sans-serif;">
                    <i class="fa-solid fa-school me-2" style="color:#6366f1;"></i>আমার নিবন্ধিত স্কুলসমূহ
                </h4>
                <p class="text-muted small mb-0">আপনার রেফারেন্সে নিবন্ধিত সকল স্কুলের তালিকা ও সার্বিক বিবরণ</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('rep.dashboard') }}" class="btn px-3 py-2 fw-semibold"
                   style="background:#f1f5f9;color:#475569;border-radius:12px;border:none;">
                    <i class="fa-solid fa-arrow-left me-1"></i>ড্যাশবোর্ড
                </a>
                <a href="{{ route('manage.schools.create') }}" class="btn px-4 py-2 fw-semibold shadow-sm"
                   style="background:linear-gradient(135deg,#10b981,#059669);color:white;border-radius:12px;border:none;">
                    <i class="fa-solid fa-plus me-1"></i>নতুন স্কুল নিবন্ধন
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="alert border-0 mb-4 px-4 py-3 d-flex align-items-center gap-3 shadow-sm"
             style="background:#ecfdf5;color:#065f46;border-radius:14px;border-left:4px solid #10b981 !important;">
            <i class="fa-solid fa-circle-check fa-lg text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif
        @if(session('error'))
        <div class="alert border-0 mb-4 px-4 py-3 d-flex align-items-center gap-3 shadow-sm"
             style="background:#fef2f2;color:#991b1b;border-radius:14px;border-left:4px solid #ef4444 !important;">
            <i class="fa-solid fa-circle-exclamation fa-lg text-danger"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        {{-- Stats Row --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <a href="{{ route('rep.schools.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm p-3 text-center h-100"
                         style="border-radius:16px;border-top:3px solid #6366f1 !important;{{ !request('status') ? 'background:#eef2ff;' : '' }}">
                        <div class="h3 fw-bold mb-0 text-dark">{{ $allCount ?? $schools->count() }}</div>
                        <div class="text-muted small fw-semibold">মোট নিবন্ধিত</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('rep.schools.index', ['status' => 'approved']) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm p-3 text-center h-100"
                         style="border-radius:16px;border-top:3px solid #10b981 !important;{{ request('status') === 'approved' ? 'background:#ecfdf5;' : '' }}">
                        <div class="h3 fw-bold mb-0 text-success">{{ $approvedCount ?? 0 }}</div>
                        <div class="text-muted small fw-semibold">অনুমোদিত স্কুল</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('rep.schools.index', ['status' => 'pending']) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm p-3 text-center h-100"
                         style="border-radius:16px;border-top:3px solid #f59e0b !important;{{ request('status') === 'pending' ? 'background:#fffbeb;' : '' }}">
                        <div class="h3 fw-bold mb-0 text-warning">{{ $pendingCount ?? 0 }}</div>
                        <div class="text-muted small fw-semibold">অপেক্ষারত (Pending)</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('rep.schools.index', ['status' => 'rejected']) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm p-3 text-center h-100"
                         style="border-radius:16px;border-top:3px solid #ef4444 !important;{{ request('status') === 'rejected' ? 'background:#fef2f2;' : '' }}">
                        <div class="h3 fw-bold mb-0 text-danger">{{ $rejectedCount ?? 0 }}</div>
                        <div class="text-muted small fw-semibold">বাতিল (Rejected)</div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Filter & Search Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:18px;">
            <div class="p-3">
                <form method="GET" action="{{ route('rep.schools.index') }}" class="row g-2 align-items-center">
                    {{-- Status Pills --}}
                    <div class="col-md-7">
                        <div class="d-flex flex-wrap gap-1">
                            <a href="{{ route('rep.schools.index', array_merge(request()->except('status'), [])) }}"
                               class="btn btn-sm px-3 py-1 fw-semibold {{ !request('status') ? 'btn-primary' : 'btn-light' }}"
                               style="border-radius:10px;font-size:0.82rem;">
                                সব ({{ $allCount ?? $schools->count() }})
                            </a>
                            <a href="{{ route('rep.schools.index', array_merge(request()->except('status'), ['status' => 'approved'])) }}"
                               class="btn btn-sm px-3 py-1 fw-semibold {{ request('status') === 'approved' ? 'btn-success' : 'btn-light' }}"
                               style="border-radius:10px;font-size:0.82rem;">
                                অনুমোদিত ({{ $approvedCount ?? 0 }})
                            </a>
                            <a href="{{ route('rep.schools.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}"
                               class="btn btn-sm px-3 py-1 fw-semibold {{ request('status') === 'pending' ? 'btn-warning' : 'btn-light' }}"
                               style="border-radius:10px;font-size:0.82rem;">
                                অপেক্ষারত ({{ $pendingCount ?? 0 }})
                            </a>
                            <a href="{{ route('rep.schools.index', array_merge(request()->except('status'), ['status' => 'rejected'])) }}"
                               class="btn btn-sm px-3 py-1 fw-semibold {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-light' }}"
                               style="border-radius:10px;font-size:0.82rem;">
                                বাতিল ({{ $rejectedCount ?? 0 }})
                            </a>
                        </div>
                    </div>

                    {{-- Search Input --}}
                    <div class="col-md-5">
                        <div class="input-group">
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control form-control-sm"
                                   placeholder="স্কুলের নাম, কোড বা জেলা খুঁজুন..."
                                   style="border-radius:10px 0 0 10px;border-color:#e2e8f0;font-size:0.88rem;">
                            <button type="submit" class="btn btn-sm btn-primary px-3" style="border-radius:0 10px 10px 0;">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            @if(request('search') || request('status'))
                            <a href="{{ route('rep.schools.index') }}" class="btn btn-sm btn-outline-secondary ms-1" style="border-radius:10px;" title="রিসেট">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Schools Table --}}
        <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
            <div class="px-4 py-3 bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #f1f5f9;">
                <h6 class="mb-0 fw-bold text-dark">
                    স্কুল তালিকা
                    @if(request('status'))
                        <span class="badge bg-secondary-subtle text-secondary ms-1">{{ ucfirst(request('status')) }}</span>
                    @endif
                </h6>
                <span class="text-muted small">মোট প্রদর্শিত: {{ $schools->count() }}টি</span>
            </div>
            <div class="p-0">
                @if($schools->isEmpty())
                <div class="text-center py-5">
                    <div style="width:80px;height:80px;background:#f8fafc;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                        <i class="fa-solid fa-school fa-2x text-muted opacity-40"></i>
                    </div>
                    <h6 class="text-muted fw-semibold">কোনো স্কুল পাওয়া যায়নি</h6>
                    <p class="text-muted small">আপনার অনুসন্ধানের সাথে মিল রেখে কোনো স্কুলের রেকর্ড পাওয়া যায়নি</p>
                    @if(request('search') || request('status'))
                    <a href="{{ route('rep.schools.index') }}" class="btn btn-sm btn-light px-3 py-2 mt-1">
                        ফিল্টার রিসেট করুন
                    </a>
                    @else
                    <a href="{{ route('manage.schools.create') }}" class="btn px-4 py-2 mt-2 fw-semibold"
                       style="background:linear-gradient(135deg,#10b981,#059669);color:white;border-radius:12px;border:none;">
                        <i class="fa-solid fa-plus me-1"></i>প্রথম স্কুল নিবন্ধন করুন
                    </a>
                    @endif
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.92rem;">
                        <thead>
                            <tr style="background:#f8fafc;color:#64748b;font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">
                                <th class="px-4 py-3 border-0">স্কুল ও কোড</th>
                                <th class="py-3 border-0">অবস্থান</th>
                                <th class="py-3 border-0">প্যাকেজ</th>
                                <th class="py-3 border-0">স্ট্যাটাস</th>
                                <th class="py-3 border-0">নিবন্ধন তারিখ</th>
                                <th class="py-3 border-0 text-center">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schools as $school)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:42px;height:42px;background:#eef2ff;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            @if($school->logo)
                                                <img src="{{ asset($school->logo) }}" style="width:36px;height:36px;object-fit:contain;border-radius:8px;">
                                            @else
                                                <i class="fa-solid fa-school" style="color:#6366f1;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $school->name ?? '—' }}</div>
                                            <div class="text-muted small" style="font-size:0.75rem;">
                                                <code>{{ $school->app_code ?? 'N/A' }}</code>
                                                @if($school->slug)
                                                    &bull; <span class="text-primary">{{ $school->slug }}.{{ $mainDomain }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="text-dark">{{ $school->district ?? '—' }}</div>
                                    <div class="text-muted small">{{ $school->division ?? '' }}</div>
                                </td>
                                <td class="py-3">
                                    <span class="badge px-3 py-2" style="background:#f0f9ff;color:#0369a1;border-radius:10px;font-size:0.78rem;">
                                        {{ $school->subscriptionPackage?->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if($school->status === 'approved')
                                        <span class="badge px-3 py-2" style="background:#ecfdf5;color:#065f46;border-radius:10px;font-size:0.78rem;">
                                            <i class="fa-solid fa-circle-check me-1"></i>অনুমোদিত
                                        </span>
                                    @elseif($school->status === 'pending')
                                        <span class="badge px-3 py-2" style="background:#fffbeb;color:#92400e;border-radius:10px;font-size:0.78rem;">
                                            <i class="fa-solid fa-clock me-1"></i>অপেক্ষারত
                                        </span>
                                    @else
                                        <span class="badge px-3 py-2" style="background:#fef2f2;color:#991b1b;border-radius:10px;font-size:0.78rem;">
                                            <i class="fa-solid fa-circle-xmark me-1"></i>বাতিল
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-muted small">{{ $school->created_at->format('d M Y') }}</td>
                                <td class="py-3 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        {{-- Tenant link if approved --}}
                                        @if($school->status === 'approved' && $school->slug)
                                        <a href="http://{{ $school->slug }}.{{ $mainDomain }}" target="_blank"
                                           class="btn btn-sm px-2 py-1" title="স্কুল সাইট ভিজিট করুন"
                                           style="background:#eef2ff;color:#6366f1;border-radius:8px;font-size:0.8rem;">
                                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>ভিজিট
                                        </a>
                                        @endif

                                        {{-- Delete Request Logic --}}
                                        @if(in_array($school->id, $pendingDeleteSchoolIds))
                                            <span class="badge px-3 py-2" style="background:#fef3c7;color:#92400e;border-radius:10px;font-size:0.78rem;">
                                                <i class="fa-solid fa-hourglass-half me-1"></i>ডিলিট পেন্ডিং
                                            </span>
                                        @elseif($school->status === 'approved')
                                            <button type="button" class="btn btn-sm px-3 py-1 fw-semibold"
                                                    onclick="openDeleteModal({{ $school->id }}, '{{ addslashes($school->name) }}')"
                                                    style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:8px;font-size:0.78rem;">
                                                <i class="fa-solid fa-trash-can me-1"></i>ডিলিট রিকোয়েস্ট
                                            </button>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Delete Request Modal --}}
<div class="modal fade" id="deleteRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:20px;overflow:hidden;">
            <div class="modal-header px-4 py-3" style="background:#fef2f2;border-bottom:1px solid #fecaca;">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>স্কুল ডিলিট রিকোয়েস্ট
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteRequestForm" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    <div class="p-3 mb-4 rounded-3" style="background:#fffbeb;border:1px solid #fed7aa;">
                        <p class="mb-0 text-sm" style="color:#92400e;font-size:0.88rem;">
                            <i class="fa-solid fa-info-circle me-2"></i>
                            আপনি <strong id="deleteSchoolName"></strong> স্কুলটি ডিলিট করার অনুরোধ পাঠাচ্ছেন।
                            এই রিকোয়েস্টটি সুপার অ্যাডমিন বা HR অনুমোদনের পর কার্যকর হবে।
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" for="delete_reason">ডিলিট করার কারণ <span class="text-danger">*</span></label>
                        <textarea name="reason" id="delete_reason" class="form-control" rows="4"
                                  placeholder="কেন এই স্কুলটি ডিলিট করতে চাইছেন তা বিস্তারিত লিখুন (কমপক্ষে ১০ অক্ষর)..."
                                  style="border-radius:12px;border-color:#e2e8f0;font-size:0.9rem;" required minlength="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light" style="border-top:1px solid #f1f5f9;">
                    <button type="button" class="btn px-4 py-2 fw-semibold"
                            data-bs-dismiss="modal"
                            style="background:#e2e8f0;color:#475569;border-radius:12px;border:none;">বাতিল করুন</button>
                    <button type="submit" class="btn px-4 py-2 fw-semibold"
                            style="background:linear-gradient(135deg,#dc2626,#b91c1c);color:white;border-radius:12px;border:none;">
                        <i class="fa-solid fa-paper-plane me-2"></i>রিকোয়েস্ট পাঠান
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(schoolId, schoolName) {
    document.getElementById('deleteSchoolName').textContent = schoolName;
    document.getElementById('deleteRequestForm').action = '/representative/request-delete/' + schoolId;
    new bootstrap.Modal(document.getElementById('deleteRequestModal')).show();
}
</script>
@endsection
