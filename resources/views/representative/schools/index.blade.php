@extends('layouts.main')

@section('title', 'আমার স্কুলসমূহ')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color:#1e293b;">
                    <i class="fa-solid fa-school me-2" style="color:#6366f1;"></i>আমার নিবন্ধিত স্কুলসমূহ
                </h4>
                <p class="text-muted small mb-0">আপনার রেফারেন্সে নিবন্ধিত সকল স্কুল</p>
            </div>
            <a href="{{ route('rep.school.register') }}" class="btn px-4 py-2 fw-semibold"
               style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;border-radius:14px;border:none;box-shadow:0 4px 12px rgba(99,102,241,0.3);">
                <i class="fa-solid fa-plus me-2"></i>নতুন স্কুল নিবন্ধন
            </a>
        </div>

        @if(session('success'))
        <div class="alert border-0 mb-4 px-4 py-3" style="background:#ecfdf5;color:#065f46;border-radius:14px;border-left:4px solid #10b981 !important;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert border-0 mb-4 px-4 py-3" style="background:#fef2f2;color:#991b1b;border-radius:14px;border-left:4px solid #ef4444 !important;">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
        </div>
        @endif

        {{-- Stats Row --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-radius:16px;">
                    <div class="h3 fw-bold mb-0" style="color:#6366f1;">{{ $schools->count() }}</div>
                    <div class="text-muted small">মোট স্কুল</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-radius:16px;">
                    <div class="h3 fw-bold mb-0" style="color:#10b981;">{{ $schools->where('status','approved')->count() }}</div>
                    <div class="text-muted small">অনুমোদিত</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-radius:16px;">
                    <div class="h3 fw-bold mb-0" style="color:#f59e0b;">{{ $schools->where('status','pending')->count() }}</div>
                    <div class="text-muted small">পেন্ডিং</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-radius:16px;">
                    <div class="h3 fw-bold mb-0" style="color:#ef4444;">{{ $schools->where('status','rejected')->count() }}</div>
                    <div class="text-muted small">বাতিল</div>
                </div>
            </div>
        </div>

        {{-- Schools Table --}}
        <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
            <div class="px-4 py-3" style="border-bottom:1px solid #f1f5f9;">
                <h6 class="mb-0 fw-bold text-dark">স্কুল তালিকা</h6>
            </div>
            <div class="p-0">
                @if($schools->isEmpty())
                <div class="text-center py-5">
                    <div style="width:90px;height:90px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                        <i class="fa-solid fa-school fa-2x text-muted opacity-40"></i>
                    </div>
                    <h6 class="text-muted fw-semibold">এখনো কোনো স্কুল নিবন্ধন করা হয়নি</h6>
                    <p class="text-muted small">প্রথম স্কুল নিবন্ধন করে আপনার যাত্রা শুরু করুন</p>
                    <a href="{{ route('rep.school.register') }}" class="btn px-4 py-2 mt-2 fw-semibold"
                       style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;border-radius:12px;border:none;">
                        <i class="fa-solid fa-plus me-2"></i>নতুন স্কুল নিবন্ধন
                    </a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.92rem;">
                        <thead>
                            <tr style="background:#f8fafc;color:#64748b;font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">
                                <th class="px-4 py-3 border-0">স্কুল</th>
                                <th class="py-3 border-0">অবস্থান</th>
                                <th class="py-3 border-0">প্যাকেজ</th>
                                <th class="py-3 border-0">স্ট্যাটাস</th>
                                <th class="py-3 border-0">নিবন্ধনের তারিখ</th>
                                <th class="py-3 border-0 text-center">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schools as $school)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:40px;height:40px;background:#eef2ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            @if($school->logo)
                                                <img src="{{ asset($school->logo) }}" style="width:36px;height:36px;object-fit:contain;border-radius:8px;">
                                            @else
                                                <i class="fa-solid fa-school" style="color:#6366f1;font-size:1rem;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $school->name ?? '—' }}</div>
                                            <div class="text-muted small">{{ $school->app_code ?? 'N/A' }}</div>
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
                                    @if(in_array($school->id, $pendingDeleteSchoolIds))
                                        <span class="badge px-3 py-2" style="background:#fef3c7;color:#92400e;border-radius:10px;font-size:0.78rem;">
                                            <i class="fa-solid fa-hourglass-half me-1"></i>ডিলিট পেন্ডিং
                                        </span>
                                    @elseif($school->status === 'approved')
                                        <button type="button" class="btn btn-sm px-3 py-2 fw-semibold"
                                                onclick="openDeleteModal({{ $school->id }}, '{{ addslashes($school->name) }}')"
                                                style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:10px;font-size:0.78rem;">
                                            <i class="fa-solid fa-trash-can me-1"></i>ডিলিট রিকোয়েস্ট
                                        </button>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
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
<div class="modal fade" id="deleteRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius:20px;overflow:hidden;">
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
                        <p class="mb-0 text-sm" style="color:#92400e;">
                            <i class="fa-solid fa-info-circle me-2"></i>
                            আপনি <strong id="deleteSchoolName"></strong> স্কুলটি ডিলিট করার অনুরোধ পাঠাচ্ছেন।
                            এই রিকোয়েস্টটি সুপার অ্যাডমিনের অনুমোদনের পর কার্যকর হবে।
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" for="delete_reason">ডিলিট করার কারণ <span class="text-danger">*</span></label>
                        <textarea name="reason" id="delete_reason" class="form-control" rows="4"
                                  placeholder="কেন এই স্কুলটি ডিলিট করতে চাইছেন তা বিস্তারিত লিখুন..."
                                  style="border-radius:12px;border-color:#e2e8f0;font-size:0.9rem;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top:1px solid #f1f5f9;">
                    <button type="button" class="btn px-4 py-2 fw-semibold"
                            data-bs-dismiss="modal"
                            style="background:#f1f5f9;color:#64748b;border-radius:12px;border:none;">বাতিল করুন</button>
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
