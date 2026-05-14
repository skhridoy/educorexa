@extends('layouts.school')

@section('customCSS')
<style>
    .msg-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .msg-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 10px 10px -5px rgba(15, 23, 42, 0.04);
        border-color: #e2e8f0;
    }
    .msg-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }
    .msg-badge {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        padding: 4px 10px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #64748b;
    }
    .msg-content {
        color: #475569;
        font-size: 0.9rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .msg-footer {
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-wa {
        background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
        color: white !important;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        text-decoration: none !important;
    }
    .btn-wa:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
    }
    .btn-msg-delete {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #fff1f2;
        color: #e11d48 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #fee2e2;
        transition: all 0.3s;
    }
    .btn-msg-delete:hover {
        background: #ffe4e6;
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center grid-margin mb-5">
        <div>
            <h4 class="fw-bold text-slate-800" style="font-size: 1.5rem; letter-spacing: -0.02em;">Website Inquiries</h4>
            <p class="text-muted">Direct messages from parents and visitors via the school website.</p>
        </div>
        <div class="d-inline-flex align-items-center gap-3 bg-white p-2 px-3 rounded-pill border shadow-sm">
            <div class="bg-indigo-soft rounded-circle p-2">
                <i data-feather="mail" style="width:18px; height:18px; color:#4f46e5;"></i>
            </div>
            <div class="text-start">
                <div class="fw-bold" style="font-size:1.1rem; line-height:1;">{{ $messages->count() }}</div>
                <div class="text-muted" style="font-size:0.75rem;">Total Messages</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($messages as $msg)
        <div class="col-xl-4 col-md-6">
            <div class="msg-card h-100 d-flex flex-column">
                <div class="p-4 flex-grow-1">
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="msg-avatar">
                            {{ strtoupper(substr($msg->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold text-slate-800" style="font-size: 1rem;">{{ $msg->name }}</h6>
                            <div class="d-flex flex-column gap-1">
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <i data-feather="phone" style="width:12px; height:12px;"></i> {{ $msg->phone ?? 'N/A' }}
                                </div>
                                @if($msg->email)
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <i data-feather="mail" style="width:12px; height:12px;"></i> {{ $msg->email }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="msg-content">
                        "{{ $msg->message }}"
                    </div>

                    <div class="d-flex align-items-center gap-2 text-muted small mt-auto">
                        <i data-feather="clock" style="width:12px; height:12px;"></i> 
                        {{ $msg->created_at->diffForHumans() }}
                    </div>
                </div>

                <div class="msg-footer">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.messages.show', ['tenant' => $tenant, 'id' => $msg->id]) }}" class="btn btn-sm btn-light d-flex align-items-center gap-1" style="border-radius: 8px; font-weight: 600; padding: 8px 12px;">
                            <i data-feather="maximize-2" style="width:14px; height:14px;"></i> Details
                        </a>
                        @php
                            $wa = preg_replace('/[^0-9]/', '', $msg->phone);
                            if(strlen($wa) == 11) $wa = '88' . $wa;
                        @endphp
                        @if($msg->phone)
                        <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn-wa" style="padding: 8px 14px; border-radius: 8px; font-size: 0.75rem;">
                            <i class="fa-brands fa-whatsapp fs-6"></i> WhatsApp
                        </a>
                        @endif
                    </div>
                    <form action="{{ route('admin.messages.destroy', ['tenant' => $tenant, 'id' => $msg->id]) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn-msg-delete" title="Delete Message" onclick="confirmDelete(this)">
                            <i data-feather="trash-2" style="width:16px; height:16px;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 py-5 text-center">
            <div class="bg-white rounded-4 p-5 border border-dashed mx-auto" style="max-width: 400px; border-radius: 20px;">
                <div class="mb-4">
                    <div class="bg-slate-50 rounded-circle d-inline-flex p-4">
                        <i data-feather="inbox" style="width:48px; height:48px; color:#94a3b8;"></i>
                    </div>
                </div>
                <h5 class="fw-bold text-slate-800">No Messages Yet</h5>
                <p class="text-muted mb-0">When parents message you via the school website, they will appear here.</p>
            </div>
        </div>
        @endforelse
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