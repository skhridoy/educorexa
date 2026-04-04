@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Send Newsletter to All Subscribers</h6>
            <form action="{{ route('admin.newsletter.store_mail', $tenant) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Subject</label>
                    <input type="text" name="subject" class="form-control" required placeholder="Enter subject">
                </div>
                <div class="mb-3">
                    <label class="form-label">Message Content</label>
                    <textarea name="message" class="form-control" rows="10" required id="emailEditor" placeholder="Write your message here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="link-icon" data-feather="send"></i> Send Email
                </button>
                <a href="{{ route('admin.newsletter.index', $tenant) }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection