@extends('layouts.school')

@section('customCSS')
<style>
    .ticket-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        transition: all 0.3s;
        margin-bottom: 1rem;
    }
    .ticket-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .priority-high { background: #fee2e2; color: #ef4444; }
    .priority-medium { background: #fef3c7; color: #d97706; }
    .priority-low { background: #f0fdf4; color: #22c55e; }
    
    .status-open { background: #e0e7ff; color: #4338ca; }
    .status-pending { background: #fef3c7; color: #d97706; }
    .status-resolved { background: #dcfce7; color: #15803d; }
    .status-closed { background: #f1f5f9; color: #64748b; }
    
    .badge-pill {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center grid-margin">
        <div>
            <h4 class="fw-bold">Support Help Desk</h4>
            <p class="text-muted">Need help? Create a ticket and our team will get back to you.</p>
        </div>
        <a href="{{ route('school.support.create', ['tenant' => $tenant]) }}" class="btn btn-primary d-flex align-items-center gap-2" style="border-radius: 12px; padding: 10px 20px;">
            <i data-feather="plus-circle"></i> Create New Ticket
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            @forelse($tickets as $ticket)
            <div class="ticket-card p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light p-3 rounded-3">
                            <i data-feather="message-square" style="color: #4f46e5;"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="fw-bold mb-0">{{ $ticket->subject }}</h6>
                                <span class="badge-pill priority-{{ $ticket->priority }}">{{ $ticket->priority }}</span>
                            </div>
                            <div class="small text-muted">
                                Ticket ID: <span class="fw-bold text-dark">#{{ $ticket->ticket_id }}</span> • 
                                Requested {{ $ticket->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge-pill status-{{ $ticket->status }}">{{ $ticket->status }}</span>
                        @if(!$ticket->is_read_by_school)
                        <span class="badge bg-danger rounded-circle p-1" title="New Reply"><span class="visually-hidden">New</span></span>
                        @endif
                        <a href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View Conversation
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                <div class="mb-3"><i data-feather="help-circle" style="width:48px; height:48px; opacity:0.2;"></i></div>
                <h5>No support tickets found</h5>
                <p class="text-muted">If you face any issues, feel free to create a ticket.</p>
            </div>
            @endforelse
            
            <div class="mt-4">
                {{ $tickets->links() }}
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
