@extends('layouts.school')

@section('customCSS')
<style>
    .detail-panel {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
    .detail-header {
        padding: 2rem;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }
    .msg-bubble-show {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        border-top-left-radius: 4px;
        padding: 2rem;
        position: relative;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .msg-bubble-show::after {
        content: '';
        position: absolute;
        left: -1px;
        top: 0;
        width: 4px;
        height: 100%;
        background: #4f46e5;
        border-radius: 4px 0 0 4px;
    }
    .info-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s;
    }
    .info-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }
    .info-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .side-panel-card {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #f8fafc;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .stat-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .stat-item:last-child {
        border-bottom: none;
    }
    .btn-wa {
        background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
        color: white !important;
        border: none;
        padding: 12px 28px;
        border-radius: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none !important;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.2);
    }
    .btn-wa:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3);
        color: white !important;
    }
    .btn-wa:active {
        transform: scale(0.98);
    }
    .btn-back {
        background: #ffffff;
        color: #475569 !important;
        border: 1px solid #e2e8f0;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        text-decoration: none !important;
    }
    .btn-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #1e293b !important;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="mb-4">
        <h4 class="fw-bold text-slate-800">Message Details</h4>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="detail-panel">
                <div class="detail-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:56px; height:56px; border-radius:14px; background:#4f46e5; color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.5rem; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);">
                            {{ strtoupper(substr($message->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-slate-800">{{ $message->name }}</h4>
                            <p class="text-muted small mb-0">Website Inquiry</p>
                        </div>
                    </div>
                    <div class="text-end d-none d-sm-block">
                        <span class="badge bg-indigo-soft text-indigo px-3 py-2 rounded-pill small">Received {{ $message->created_at->format('d M, Y') }}</span>
                    </div>
                </div>

                <div class="p-4 p-md-5">
                    <div class="mb-5">
                        <label class="text-slate-400 small fw-bold text-uppercase mb-3 d-block">Message Content</label>
                        <div class="msg-bubble-show">
                            <p class="mb-0 text-slate-700" style="font-size:1.1rem; line-height:1.7;">
                                {{ $message->message ?? 'No message body provided.' }}
                            </p>
                        </div>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i data-feather="phone" style="width:18px;"></i>
                                </div>
                                <div>
                                    <div class="text-slate-400 small fw-bold text-uppercase" style="font-size:0.65rem;">Phone Number</div>
                                    <div class="fw-bold text-slate-800">{{ $message->phone ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i data-feather="mail" style="width:18px;"></i>
                                </div>
                                <div>
                                    <div class="text-slate-400 small fw-bold text-uppercase" style="font-size:0.65rem;">Email Address</div>
                                    <div class="fw-bold text-slate-800">{{ $message->email ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top d-flex flex-wrap align-items-center gap-3">
                        <a href="{{ route('admin.messages.index', ['tenant' => $tenant]) }}" class="btn-back">
                            <i data-feather="arrow-left" style="width:18px;"></i> Back
                        </a>
                        
                        @php
                            $wa = preg_replace('/[^0-9]/', '', $message->phone);
                            if(strlen($wa) == 11) $wa = '88' . $wa;
                        @endphp
                        @if($message->phone)
                        <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn-wa">
                            <i class="fa-brands fa-whatsapp fs-5"></i> WhatsApp Reply
                        </a>
                        @endif

                        <form action="{{ route('admin.messages.destroy', ['tenant' => $tenant, 'id' => $message->id]) }}" method="POST" class="ms-md-auto">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-outline-danger px-4 rounded-3 d-flex align-items-center gap-2" style="height: 48px; border-radius: 14px; font-weight: 600;" onclick="confirmDelete(this)">
                                <i data-feather="trash-2" style="width:18px;"></i> Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="side-panel-card">
                <h5 class="fw-bold mb-4">Inquiry Overview</h5>
                
                <div class="stat-item d-flex align-items-center justify-content-between">
                    <span class="text-slate-400 small">Reference ID</span>
                    <span class="fw-bold">#MS{{ str_pad($message->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="stat-item d-flex align-items-center justify-content-between">
                    <span class="text-slate-400 small">Wait Time</span>
                    <span class="fw-bold">{{ $message->created_at->diffForHumans(null, true) }}</span>
                </div>

                <div class="stat-item d-flex align-items-center justify-content-between">
                    <span class="text-slate-400 small">Date Received</span>
                    <span class="fw-bold">{{ $message->created_at->format('d M, Y') }}</span>
                </div>

                <div class="mt-5 p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="d-flex align-items-center gap-3 mb-3 text-indigo">
                        <i data-feather="help-circle" style="width:20px;"></i>
                        <span class="fw-bold">Next Steps</span>
                    </div>
                    <p class="small text-slate-400 mb-0">
                        Reach out to this person via WhatsApp or email to provide the information they requested.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
function confirmDelete(btn) {
    if (confirm('আপনি কি নিশ্চিত যে এই মেসেজটি ডিলিট করতে চান?')) {
        btn.closest('form').submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>
@endsection
