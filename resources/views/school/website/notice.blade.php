@extends('school.website.layouts.app')

@section('customCSS')
<style>
    .notice-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        background: #ffffff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .notice-card h4 {
        margin-bottom: 8px;
        color: #002147;
        font-weight: 700;
    }
    .notice-card .date {
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 12px;
    }
    .notice-card a.download {
        display: inline-block;
        margin-top: 8px;
        color: #F9B800;
        font-weight: 600;
    }
    .notice-card a.download:hover {
        color: #e0a500;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4" style="color:#002147; font-weight: 800;">All Notices</h2>
    @if($notices->isEmpty())
        <p class="text-center text-muted">No notices available at the moment.</p>
    @else
        @foreach($notices as $notice)
            <div class="notice-card">
                <h4>{{ $notice->title }}</h4>
                <div class="date">{{ date('d M Y', strtotime($notice->notice_date)) }}</div>
                @if(!empty($notice->description))
                    <p>{{ $notice->description }}</p>
                @endif
                @if(!empty($notice->file))
                    <a href="{{ asset($notice->file) }}" target="_blank" class="download">Download Attachment</a>
                @endif
            </div>
        @endforeach
    @endif
</div>
@endsection
