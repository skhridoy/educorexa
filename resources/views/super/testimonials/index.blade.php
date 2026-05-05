@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Testimonials</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-quote-left me-2" style="color:#4f46e5;"></i> Testimonials</h2>
            <p class="edu-page-sub">Review and manage success stories from school admins.</p>
        </div>
        <a href="{{ route('super.testimonials.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Add Testimonial
        </a>
    </div>

    <div class="row g-4">
        @forelse($testimonials as $testimonial)
        <div class="col-md-6 col-lg-4">
            <div class="edu-panel h-100" style="display:flex; flex-direction:column; position:relative; {{ !$testimonial->is_active ? 'opacity:0.8;' : '' }}">
                <div class="edu-panel-bd" style="flex:1;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            @php
                                $imageUrl = null;
                                if ($testimonial->user_id && $testimonial->user) {
                                    $folder = ($testimonial->user->role === 'super_admin') ? 'super_admin' : 'employees';
                                    $imageUrl = ($testimonial->user->photo) 
                                                ? asset('uploads/' . $folder . '/' . $testimonial->user->photo) 
                                                : null;
                                }
                                
                                if (!$imageUrl) {
                                    $imageUrl = ($testimonial->image) ? asset($testimonial->image) : asset('assets/images/profile.webp');
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 onerror="this.src='{{ asset('assets/images/profile.webp') }}'"
                                 alt="image" 
                                 style="width:50px; height:50px; object-fit:cover; border-radius:12px; border:2px solid #eef2ff;">
                            <div>
                                <h6 style="font-weight:700; color:#1e293b; margin:0; font-size:0.95rem;">{{ $testimonial->name }}</h6>
                                <p style="margin:0; font-size:0.75rem; color:#94a3b8;">
                                    {{ $testimonial->designation }}{{ $testimonial->institution_name ? ', '.$testimonial->institution_name : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom:12px;">
                        @for($i=1; $i<=5; $i++)
                            <i class="fa-solid fa-star {{ $i <= $testimonial->rating ? 'star-filled' : 'star-empty' }}" style="font-size:12px;"></i>
                        @endfor
                    </div>

                    <p style="color:#64748b; font-size:0.875rem; line-height:1.6; font-style:italic; margin-bottom:0;">
                        "{{ Str::limit($testimonial->message, 150) }}"
                    </p>
                </div>

                <div style="padding:16px 28px; background:#fafbff; border-top:1px solid #f8fafc; display:flex; justify-content:space-between; align-items:center; border-radius:0 0 16px 16px;">
                    <div class="d-flex gap-1">
                        <a href="{{ route('super.testimonials.edit', $testimonial->id) }}" class="act-btn" title="Edit">
                            <i data-feather="edit-2" style="width:14px; height:14px;"></i>
                        </a>
                        <form action="{{ route('super.testimonials.destroy', $testimonial->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this testimonial?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="act-btn del" title="Delete">
                                <i data-feather="trash-2" style="width:14px; height:14px;"></i>
                            </button>
                        </form>
                    </div>

                    <form action="{{ route('super.testimonials.toggle', $testimonial->id) }}" method="POST">
                        @csrf @method('PATCH')
                        @if($testimonial->is_active)
                            <button type="submit" class="badge-green" style="border:none; cursor:pointer;">
                                <i data-feather="check-circle" style="width:12px; height:12px; margin-right:4px;"></i> Active
                            </button>
                        @else
                            <button type="submit" class="badge-amber" style="border:none; cursor:pointer;">
                                <i data-feather="clock" style="width:12px; height:12px; margin-right:4px;"></i> Approve
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 edu-empty">
            <i class="fa-solid fa-message"></i>
            <p>No testimonials found yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
