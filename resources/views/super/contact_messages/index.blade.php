@extends('layouts.main')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage.frontend.index') }}">Frontend</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Messages</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Contact Messages</h4>
        </div>

        <div class="row g-4">
            @forelse($messages as $msg)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @php 
                                $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-danger', 'bg-warning'];
                                $bgClass = $colors[$loop->index % count($colors)];
                            @endphp
                            <div class="{{ $bgClass }} text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center fw-bold me-3" style="width:50px; height:50px;">
                                {{ strtoupper(substr($msg->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ $msg->name }}</h6>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">
                                    {{ $msg->school_name }}
                                </small>
                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                                    <i data-feather="phone" style="width: 12px; height: 12px;" class="me-1"></i> {{ $msg->phone }}
                                </small>
                            </div>
                        </div>
                        
                        <p class="text-muted small fst-italic mb-3">"{{ Str::limit($msg->message, 120) }}"</p>
                        
                        <small class="text-muted d-block mt-auto" style="font-size: 0.7rem;">
                            <i data-feather="clock" style="width: 12px; height: 12px;" class="me-1"></i> {{ $msg->created_at->format('d M Y, h:i A') }}
                        </small>
                    </div>
                    <div class="card-footer bg-transparent border-top pt-3 pb-3 d-flex justify-content-end align-items-center">
                        <div class="d-flex gap-2">
                            <a href="{{ route('manage.contact.show', $msg->id) }}" class="btn btn-sm btn-light border shadow-sm text-primary fw-bold px-3" title="View Details">
                                <i data-feather="eye" style="width: 14px; height: 14px;" class="me-1"></i> View
                            </a>
                            <form action="{{ route('manage.contact.destroy', $msg->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-light border text-danger shadow-sm px-3 fw-bold" title="Delete" onclick="confirmDelete(this)">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;" class="me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-light rounded-4">
                    <i data-feather="mail" class="text-muted mb-3" style="width: 40px; height: 40px;"></i>
                    <h5 class="text-muted">No messages found.</h5>
                    <p class="text-muted small">New contact messages will appear here.</p>
                </div>
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
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this message?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',

        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                button.closest('form').submit();

            }
        })
    }
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}', // প্রথম এরর মেসেজটি দেখাবে
            confirmButtonColor: '#3085d6',
        });
    @endif
    @if(session('success'))
    Swal.fire({
        icon: '{{ session('type', 'success') }}',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif
</script>
@endsection