@extends('layouts.main')

@section('customCSS')
@include('layouts._shared_styles')
<style>
    .ticket-row {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        transition: all 0.3s;
        margin-bottom: 0.75rem;
    }
    .ticket-row:hover {
        transform: translateX(5px);
        border-color: #4f46e5;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
    }
    .badge-pill {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .priority-high { background: #fee2e2; color: #ef4444; }
    .priority-medium { background: #fef3c7; color: #d97706; }
    .priority-low { background: #f0fdf4; color: #22c55e; }
    
    .status-open { background: #e0e7ff; color: #4338ca; }
    .status-pending { background: #fef3c7; color: #d97706; }
    .status-resolved { background: #dcfce7; color: #15803d; }
    .status-closed { background: #f1f5f9; color: #64748b; }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <h2 class="fw-bold text-slate-800">School Support Desk</h2>
                <p class="text-muted">Manage technical and general inquiries from registered school admins.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="bg-white p-3 rounded-4 border d-inline-flex align-items-center gap-3">
                    <div class="bg-indigo-soft p-2 rounded-circle">
                        <i data-feather="help-circle" style="color:#4f46e5;"></i>
                    </div>
                    <div class="text-start">
                        <div class="fw-bold fs-5" style="line-height:1;">{{ $tickets->count() }}</div>
                        <div class="small text-muted">Total Tickets</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @forelse($tickets as $ticket)
                <div class="ticket-row p-3 px-4">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-slate-50 p-3 rounded-circle text-indigo">
                                    <i data-feather="file-text" style="width:20px;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-slate-800">
                                        {{ $ticket->subject }}
                                        @if(!$ticket->is_read_by_super)
                                        <span class="badge bg-danger ms-2" style="font-size:0.5rem; vertical-align: middle;">NEW</span>
                                        @endif
                                    </h6>
                                    <div class="small text-muted">
                                        School: <span class="fw-bold text-indigo">{{ $ticket->school->name }}</span> • 
                                        Ticket ID: <span class="fw-bold">#{{ $ticket->ticket_id }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="badge-pill priority-{{ $ticket->priority }}">{{ $ticket->priority }}</span>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="badge-pill status-{{ $ticket->status }}">{{ $ticket->status }}</span>
                        </div>
                        <div class="col-md-3 text-end">
                            <div class="text-muted small mb-2">{{ $ticket->created_at->diffForHumans() }}</div>
                            <a href="{{ route('manage.support.show', $ticket->id) }}" class="btn btn-sm btn-indigo rounded-pill px-4">
                                Handle Ticket
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                    <div class="mb-4"><i data-feather="smile" style="width:64px; height:64px; color:#94a3b8;"></i></div>
                    <h5 class="fw-bold text-slate-800">No active support tickets</h5>
                    <p class="text-muted">All quiet on the help desk front. Good job!</p>
                </div>
                @endforelse

                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endsection
