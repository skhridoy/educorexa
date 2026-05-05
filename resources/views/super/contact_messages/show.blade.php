@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    .msg-bubble { background:#f8fafc; border-radius:20px; border-top-left-radius:4px; padding:24px; border:1px solid #f1f5f9; position:relative; }
    .msg-bubble::before { content:'"'; position:absolute; top:10px; left:15px; font-family:'Outfit',sans-serif; font-size:4rem; color:#e2e8f0; line-height:1; }
    .msg-text { font-size:1.05rem; color:#1e293b; line-height:1.7; position:relative; z-index:1; white-space:pre-line; }
    
    .lead-card { background:linear-gradient(135deg, #4f46e5, #7c3aed); color:#fff; border-radius:16px; padding:24px; }
    .lead-stat { display:flex; align-items:center; gap:12px; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid rgba(255,255,255,0.15); }
    .lead-stat:last-child { border-bottom:none; margin-bottom:0; padding-bottom:0; }
    .lead-icon { width:40px; height:40px; border-radius:12px; background:rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('manage.contact.index') }}">Contact Messages</a></li>
        <li><span>/</span></li>
        <li class="active">Message Details</li>
    </ul>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="edu-panel">
                <div class="edu-panel-hd">
                    <h6 class="edu-panel-ttl">Message Detail</h6>
                    <span style="font-size:0.75rem; color:#94a3b8;">Received {{ $message->created_at->format('d M, Y \a\t h:i A') }}</span>
                </div>
                <div class="edu-panel-bd">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="width:60px; height:60px; border-radius:15px; background:#eef2ff; color:#4f46e5; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.5rem;">
                            {{ strtoupper(substr($message->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 style="font-family:'Outfit',sans-serif; font-weight:700; color:#1e293b; margin:0;">{{ $message->name }}</h4>
                            <p style="margin:0; color:#64748b; font-weight:600;">{{ $message->school_name ?? 'Individual Inquiry' }}</p>
                        </div>
                    </div>

                    <div class="msg-bubble mb-5">
                        <div class="msg-text">{{ $message->message ?? 'No message body.' }}</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div style="background:#fff; border:1px solid #f1f5f9; border-radius:14px; padding:15px 20px; display:flex; align-items:center; gap:12px;">
                                <div style="color:#4f46e5;"><i data-feather="phone" style="width:18px;"></i></div>
                                <div>
                                    <div style="font-size:0.7rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Phone Number</div>
                                    <div style="font-weight:700; color:#1e293b;">{{ $message->phone }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="background:#fff; border:1px solid #f1f5f9; border-radius:14px; padding:15px 20px; display:flex; align-items:center; gap:12px;">
                                <div style="color:#4f46e5;"><i data-feather="mail" style="width:18px;"></i></div>
                                <div>
                                    <div style="font-size:0.7rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Contact Channel</div>
                                    <div style="font-weight:700; color:#1e293b;">Direct Message</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="edu-divider"></div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('manage.contact.index') }}" class="btn-edu btn-edu-light">
                            <i data-feather="arrow-left" style="width:15px;"></i> Back to List
                        </a>
                        
                        @php
                            $wa = preg_replace('/[^0-9]/', '', $message->phone);
                            if(strlen($wa) == 11) $wa = '88' . $wa;
                        @endphp
                        <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn-edu" style="background:#25d366; color:#fff;">
                            <i class="fa-brands fa-whatsapp me-2"></i> Open WhatsApp
                        </a>

                        <form action="{{ route('manage.contact.destroy', $message->id) }}" method="POST" class="ms-md-auto">
                            @csrf @method('DELETE')
                            <button type="button" class="btn-edu btn-edu-danger" onclick="confirmDelete(this)">
                                <i data-feather="trash-2" style="width:15px;"></i> Delete Lead
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="lead-card">
                <h5 style="font-family:'Outfit',sans-serif; font-weight:700; margin-bottom:24px;">Lead Overview</h5>
                
                <div class="lead-stat">
                    <div class="lead-icon"><i data-feather="clock" style="width:18px;"></i></div>
                    <div>
                        <div style="font-size:0.75rem; opacity:0.8;">Received</div>
                        <div style="font-weight:700;">{{ $message->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <div class="lead-stat">
                    <div class="lead-icon"><i data-feather="activity" style="width:18px;"></i></div>
                    <div>
                        <div style="font-size:0.75rem; opacity:0.8;">Priority</div>
                        <div style="font-weight:700;">Normal</div>
                    </div>
                </div>

                <div class="lead-stat">
                    <div class="lead-icon"><i data-feather="check-circle" style="width:18px;"></i></div>
                    <div>
                        <div style="font-size:0.75rem; opacity:0.8;">Status</div>
                        <div style="font-weight:700;">Active Inquiry</div>
                    </div>
                </div>

                <div style="margin-top:30px; background:rgba(255,255,255,0.1); border-radius:12px; padding:15px; font-size:0.8rem; line-height:1.5;">
                    <i class="fa-solid fa-circle-info me-1"></i> Use the action buttons to contact this lead via WhatsApp or delete the record if processed.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
function confirmDelete(btn) {
    Swal.fire({ title:'Delete Lead?', text:'This record will be permanently removed.', icon:'warning',
        showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#6b7280', confirmButtonText:'Yes, delete' })
        .then(r => { if(r.isConfirmed) btn.closest('form').submit(); });
}
</script>
@endsection