@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Contact Messages</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-envelope-open-text me-2" style="color:#4f46e5;"></i> Contact Messages</h2>
            <p class="edu-page-sub">Read and respond to inquiries from prospective clients.</p>
        </div>
        <span class="badge-indigo" style="font-size:0.82rem; padding:6px 14px;">
            {{ $messages->count() }} Messages
        </span>
    </div>

    <div class="row g-4">
        @forelse($messages as $msg)
        <div class="col-md-6 col-lg-4">
            <div class="edu-panel h-100" style="display:flex; flex-direction:column;">
                <div class="edu-panel-bd" style="flex:1;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:50px; height:50px; border-radius:12px; background:#eef2ff; color:#4f46e5; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.2rem; flex-shrink:0;">
                            {{ strtoupper(substr($msg->name, 0, 1)) }}
                        </div>
                        <div>
                            <h6 style="font-weight:700; color:#1e293b; margin:0; font-size:0.95rem;">{{ $msg->name }}</h6>
                            <p style="margin:0; font-size:0.75rem; color:#4f46e5; font-weight:600;">{{ $msg->school_name }}</p>
                            <p style="margin:4px 0 0; font-size:0.75rem; color:#94a3b8;">
                                <i data-feather="phone" style="width:11px; height:11px; margin-right:4px;"></i> {{ $msg->phone }}
                            </p>
                        </div>
                    </div>
                    
                    <p style="color:#64748b; font-size:0.875rem; line-height:1.6; margin-bottom:16px;">
                        "{{ Str::limit($msg->message, 120) }}"
                    </p>
                    
                    <div style="margin-top:auto; font-size:0.72rem; color:#94a3b8; display:flex; align-items:center; gap:5px;">
                        <i data-feather="clock" style="width:12px; height:12px;"></i> {{ $msg->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>

                <div style="padding:16px 28px; background:#fafbff; border-top:1px solid #f8fafc; display:flex; justify-content:flex-end; align-items:center; border-radius:0 0 16px 16px; gap:8px;">
                    <a href="{{ route('manage.contact.show', $msg->id) }}" class="btn-edu btn-edu-light" style="padding:7px 16px; font-size:0.8rem;">
                        <i data-feather="eye" style="width:14px; height:14px;"></i> View Message
                    </a>
                    <form action="{{ route('manage.contact.destroy', $msg->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="act-btn del" title="Delete" onclick="confirmDelete(this)">
                            <i data-feather="trash-2" style="width:14px; height:14px;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 edu-empty">
            <i class="fa-solid fa-inbox"></i>
            <p>No messages found.</p>
        </div>
        @endforelse
    </div>

    @if($messages->hasPages())
    <div class="mt-4">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection

@section('customJs')
<script>
function confirmDelete(btn) {
    Swal.fire({ title:'Delete Message?', text:'This action will remove the record permanently.',
        icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#6b7280',
        confirmButtonText:'Yes, delete' })
        .then(r => { if(r.isConfirmed) btn.closest('form').submit(); });
}
</script>
@endsection