@extends('layouts.main')
@section('customCSS') 
    @include('layouts._shared_styles')
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
        .msg-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4f46e5;
            position: absolute;
            top: 20px;
            right: 20px;
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
        .btn-msg-view {
            background: white;
            color: #1e293b !important;
            border: 1px solid #e2e8f0;
            padding: 8px 18px;
            border-radius: 12px;
            font-size: 0.825rem;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-msg-view:hover {
            background: #f8fafc;
            color: #4f46e5 !important;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .btn-msg-delete {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #fff1f2;
            color: #e11d48 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #fee2e2;
            transition: all 0.3s;
            text-decoration: none !important;
        }
        .btn-msg-delete:hover {
            background: #ffe4e6;
            color: #be123c !important;
            transform: scale(1.05);
            border-color: #fecaca;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2" style="background:transparent; padding:0;">
                        <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}" style="color:#64748b; text-decoration:none;">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#4f46e5; font-weight:600;">Contact Messages</li>
                    </ol>
                </nav>
                <h2 class="fw-bold" style="color: #1e293b; letter-spacing: -0.02em;">Website Inquiries</h2>
                <p class="text-muted mb-0">Manage communication from prospective schools and partners.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
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
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="msg-badge">{{ $msg->school_name ?? 'Individual' }}</span>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <div class="text-muted small d-flex align-items-center gap-1">
                                        <i data-feather="phone" style="width:12px; height:12px;"></i> {{ $msg->phone }}
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
                        <a href="{{ route('manage.contact.show', $msg->id) }}" class="btn-msg-view d-flex align-items-center gap-2">
                            <i data-feather="maximize-2" style="width:14px; height:14px;"></i> View Details
                        </a>
                        <form action="{{ route('manage.contact.destroy', $msg->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="button" class="btn-msg-delete" title="Delete Inquiry" onclick="confirmDelete(this)">
                                <i data-feather="trash-2" style="width:16px; height:16px;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center">
                <div class="bg-white rounded-4 p-5 border border-dashed mx-auto" style="max-width: 400px;">
                    <div class="mb-4">
                        <div class="bg-slate-50 rounded-circle d-inline-flex p-4">
                            <i data-feather="inbox" style="width:48px; height:48px; color:#94a3b8;"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-slate-800">No Messages Yet</h5>
                    <p class="text-muted mb-0">Inquiries from the main website will appear here for your review.</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($messages->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('customJs')
<script>
function confirmDelete(btn) {
    Swal.fire({
        title: 'Delete this inquiry?',
        text: "This record will be permanently removed from your dashboard.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        border: 'none',
        borderRadius: '15px'
    }).then((result) => {
        if (result.isConfirmed) {
            btn.closest('form').submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>
@endsection