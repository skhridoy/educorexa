@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Testimonials</h4>
        <a href="{{ route('super.testimonials.create') }}" class="btn btn-primary">Add New Testimonial</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($testimonials as $testimonial)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 position-relative {{ !$testimonial->is_active ? 'bg-light' : '' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            @php
                                $imageUrl = $testimonial->user_id && $testimonial->user && $testimonial->user->photo 
                                            ? asset('uploads/profiles/' . $testimonial->user->photo) 
                                            : ($testimonial->image ? asset($testimonial->image) : null);
                            @endphp
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="image" class="rounded-circle shadow-sm me-3" style="width:50px; height:50px; object-fit:cover;">
                            @else
                                @php 
                                    $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-danger', 'bg-warning'];
                                    $bgClass = $colors[$loop->index % count($colors)];
                                @endphp
                                <div class="{{ $bgClass }} text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center fw-bold me-3" style="width:50px; height:50px;">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-bold mb-0">{{ $testimonial->name }}</h6>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">
                                    {{ $testimonial->designation }}
                                    @if($testimonial->designation && $testimonial->institution_name) , @endif
                                    {{ $testimonial->institution_name }}
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-warning small mb-2">
                        @for($i=1; $i<=5; $i++)
                            <i class="bi bi-star-fill {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                        @endfor
                    </div>
                    <p class="text-muted small fst-italic mb-4">"{{ Str::limit($testimonial->message, 150) }}"</p>
                    
                </div>
                <div class="card-footer bg-transparent border-top pt-3 pb-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-2">
                        <a href="{{ route('super.testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-light border shadow-sm" title="Edit">
                            <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                        </a>
                        <form action="{{ route('super.testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light border text-danger shadow-sm" title="Delete">
                                <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </form>
                    </div>

                    <form action="{{ route('super.testimonials.toggle', $testimonial->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if($testimonial->is_active)
                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                <i data-feather="check-circle" style="width: 14px; height: 14px;" class="me-1"></i> Active
                            </button>
                        @else
                            <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm">
                                <i data-feather="clock" style="width: 14px; height: 14px;" class="me-1"></i> Approve
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="p-5 bg-light rounded-4">
                <i data-feather="message-square" class="text-muted mb-3" style="width: 40px; height: 40px;"></i>
                <h5 class="text-muted">No testimonials found.</h5>
                <p class="text-muted small">Reviews submitted by school admins will appear here.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
