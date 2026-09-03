@extends('layouts.school')
@section('title', 'School Email Inbox')
@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h3 class="fw-bold mb-1">School Email Inbox</h3><p class="text-muted mb-0">Emails sent to {{ $school->email }} or the professional school mailbox.</p></div></div>
    <div class="card border-0 shadow-sm"><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>From</th><th>Subject</th><th>Status</th><th>Received</th><th></th></tr></thead><tbody>
    @forelse($messages as $message)<tr class="{{ !$message->is_read ? 'fw-bold' : '' }}"><td>{{ $message->sender_name ?: $message->sender_email }}<small class="d-block text-muted">{{ $message->sender_email }}</small></td><td>{{ $message->subject ?: '(No subject)' }}</td><td><span class="badge text-bg-light">{{ ucfirst($message->status) }}</span></td><td>{{ optional($message->received_at)->format('d M Y, h:i A') }}</td><td><a class="btn btn-sm btn-outline-primary" href="{{ route('school.inbox.show', ['tenant' => $school->slug, 'id' => $message->id]) }}">Open</a></td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-5">No incoming emails yet.</td></tr>@endforelse
    </tbody></table></div><div class="p-3">{{ $messages->links() }}</div></div>
</div>
@endsection
