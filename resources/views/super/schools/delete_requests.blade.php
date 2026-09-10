@extends('layouts.main')

@section('title', 'স্কুল ডিলিট রিকোয়েস্ট')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color:#1e293b;">
                    <i class="fa-solid fa-trash-can me-2" style="color:#dc2626;"></i>স্কুল ডিলিট রিকোয়েস্ট
                </h4>
                <p class="text-muted small mb-0">Representative-দের পাঠানো স্কুল ডিলিট অনুরোধ</p>
            </div>
            @if($pendingRequests->count() > 0)
            <span class="badge px-3 py-2" style="background:#fef2f2;color:#dc2626;border-radius:10px;font-size:0.9rem;">
                <i class="fa-solid fa-clock me-1"></i>{{ $pendingRequests->count() }}টি পেন্ডিং
            </span>
            @endif
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

        {{-- Pending Requests --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;overflow:hidden;">
            <div class="px-4 py-3 d-flex align-items-center gap-3" style="background:linear-gradient(135deg,#fef2f2,#fde8e8);border-bottom:1px solid #fecaca;">
                <div style="width:36px;height:36px;background:#ef4444;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-hourglass-half text-white"></i>
                </div>
                <h6 class="mb-0 fw-bold" style="color:#991b1b;">পেন্ডিং রিকোয়েস্ট ({{ $pendingRequests->count() }})</h6>
            </div>
            <div class="p-0">
                @if($pendingRequests->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-check-double fa-3x text-success opacity-40 mb-3"></i>
                    <p class="text-muted">কোনো পেন্ডিং ডিলিট রিকোয়েস্ট নেই।</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.9rem;">
                        <thead>
                            <tr style="background:#fef2f2;color:#64748b;font-size:0.78rem;font-weight:700;text-transform:uppercase;">
                                <th class="px-4 py-3 border-0">স্কুল</th>
                                <th class="py-3 border-0">Representative</th>
                                <th class="py-3 border-0">কারণ</th>
                                <th class="py-3 border-0">তারিখ</th>
                                <th class="py-3 border-0 text-center">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingRequests as $req)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="px-4 py-3">
                                    <div class="fw-semibold text-dark">{{ $req->school?->name ?? 'স্কুল মুছে গেছে' }}</div>
                                    <div class="text-muted small">{{ $req->school?->district ?? '' }} {{ $req->school?->division ? ', '.$req->school->division : '' }}</div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold text-dark">{{ $req->requester?->name ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ $req->requester?->employee?->employee_id ?? '' }}</div>
                                </td>
                                <td class="py-3" style="max-width:250px;">
                                    <div class="text-dark small" style="white-space:pre-wrap;">{{ Str::limit($req->reason, 100) }}</div>
                                </td>
                                <td class="py-3 text-muted small">{{ $req->created_at->format('d M Y, h:i A') }}</td>
                                <td class="py-3 text-center">
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        {{-- Approve Button --}}
                                        <button type="button" class="btn btn-sm px-3 py-2 fw-semibold"
                                                onclick="openApproveModal({{ $req->id }}, '{{ addslashes($req->school?->name) }}')"
                                                style="background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0;border-radius:10px;font-size:0.78rem;">
                                            <i class="fa-solid fa-check me-1"></i>অনুমোদন
                                        </button>
                                        {{-- Reject Button --}}
                                        <button type="button" class="btn btn-sm px-3 py-2 fw-semibold"
                                                onclick="openRejectModal({{ $req->id }}, '{{ addslashes($req->school?->name) }}')"
                                                style="background:#fef2f2;color:#991b1b;border:1px solid #fecaca;border-radius:10px;font-size:0.78rem;">
                                            <i class="fa-solid fa-xmark me-1"></i>প্রত্যাখ্যান
                                        </button>
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

        {{-- Recent Processed Requests --}}
        @if($allRequests->count() > 0)
        <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
            <div class="px-4 py-3" style="border-bottom:1px solid #f1f5f9;">
                <h6 class="mb-0 fw-bold text-dark">প্রসেস করা রিকোয়েস্ট (সর্বশেষ ২০টি)</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:0.88rem;">
                    <thead>
                        <tr style="background:#f8fafc;color:#64748b;font-size:0.75rem;font-weight:700;text-transform:uppercase;">
                            <th class="px-4 py-3 border-0">স্কুল</th>
                            <th class="py-3 border-0">Representative</th>
                            <th class="py-3 border-0">স্ট্যাটাস</th>
                            <th class="py-3 border-0">রিভিউ করেছেন</th>
                            <th class="py-3 border-0">নোট</th>
                            <th class="py-3 border-0">তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allRequests as $req)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td class="px-4 py-3 text-dark fw-semibold">{{ $req->school?->name ?? '(ডিলিট হয়েছে)' }}</td>
                            <td class="py-3 text-muted small">{{ $req->requester?->name ?? 'N/A' }}</td>
                            <td class="py-3">
                                @if($req->status === 'approved')
                                    <span class="badge px-2 py-1" style="background:#ecfdf5;color:#065f46;border-radius:8px;font-size:0.75rem;">অনুমোদিত</span>
                                @else
                                    <span class="badge px-2 py-1" style="background:#fef2f2;color:#991b1b;border-radius:8px;font-size:0.75rem;">প্রত্যাখ্যাত</span>
                                @endif
                            </td>
                            <td class="py-3 text-muted small">{{ $req->reviewer?->name ?? 'N/A' }}</td>
                            <td class="py-3 text-muted small" style="max-width:200px;">{{ Str::limit($req->admin_note, 60) ?? '—' }}</td>
                            <td class="py-3 text-muted small">{{ $req->reviewed_at?->format('d M Y') ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- Approve Modal --}}
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius:20px;overflow:hidden;">
            <div class="modal-header px-4 py-3" style="background:#ecfdf5;border-bottom:1px solid #bbf7d0;">
                <h5 class="modal-title fw-bold" style="color:#065f46;">
                    <i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>স্কুল ডিলিটের নিশ্চিতকরণ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    <div class="p-3 mb-4 rounded-3" style="background:#fef3c7;border:1px solid #fcd34d;">
                        <p class="mb-0 small" style="color:#92400e;">
                            <i class="fa-solid fa-warning me-2"></i>
                            আপনি <strong id="approveSchoolName"></strong> স্কুলটি স্থায়ীভাবে ডিলিট করতে যাচ্ছেন।
                            এই কাজটি পূর্বাবস্থায় ফেরানো যাবে না।
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" for="approve_note">অতিরিক্ত নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_note" id="approve_note" class="form-control" rows="3"
                                  placeholder="কোনো বিশেষ নোট থাকলে লিখুন..."
                                  style="border-radius:12px;border-color:#e2e8f0;font-size:0.9rem;"></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top:1px solid #f1f5f9;">
                    <button type="button" class="btn px-4 py-2 fw-semibold" data-bs-dismiss="modal"
                            style="background:#f1f5f9;color:#64748b;border-radius:12px;border:none;">বাতিল</button>
                    <button type="submit" class="btn px-4 py-2 fw-semibold"
                            style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white;border-radius:12px;border:none;">
                        <i class="fa-solid fa-trash-can me-2"></i>হ্যাঁ, ডিলিট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius:20px;overflow:hidden;">
            <div class="modal-header px-4 py-3" style="background:#fef2f2;border-bottom:1px solid #fecaca;">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="fa-solid fa-xmark-circle me-2"></i>রিকোয়েস্ট প্রত্যাখ্যান
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    <p class="text-muted small mb-4">
                        <strong id="rejectSchoolName"></strong> স্কুলের ডিলিট রিকোয়েস্ট প্রত্যাখ্যান করছেন।
                        কারণটি Representative-কে জানানো হবে।
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" for="reject_note">প্রত্যাখ্যানের কারণ <span class="text-danger">*</span></label>
                        <textarea name="admin_note" id="reject_note" class="form-control" rows="4"
                                  placeholder="কেন রিকোয়েস্টটি গ্রহণ করা হচ্ছে না তা জানান..."
                                  style="border-radius:12px;border-color:#e2e8f0;font-size:0.9rem;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top:1px solid #f1f5f9;">
                    <button type="button" class="btn px-4 py-2 fw-semibold" data-bs-dismiss="modal"
                            style="background:#f1f5f9;color:#64748b;border-radius:12px;border:none;">বাতিল</button>
                    <button type="submit" class="btn px-4 py-2 fw-semibold"
                            style="background:#dc2626;color:white;border-radius:12px;border:none;">
                        <i class="fa-solid fa-xmark me-2"></i>প্রত্যাখ্যান করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openApproveModal(id, schoolName) {
    document.getElementById('approveSchoolName').textContent = schoolName;
    document.getElementById('approveForm').action = '/manage/school-delete-requests/' + id + '/approve';
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function openRejectModal(id, schoolName) {
    document.getElementById('rejectSchoolName').textContent = schoolName;
    document.getElementById('rejectForm').action = '/manage/school-delete-requests/' + id + '/reject';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endsection
