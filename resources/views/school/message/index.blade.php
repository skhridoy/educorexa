@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Contact Messages</h4>
            <p class="text-muted">Messages received from the school website contact form.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th class="pt-3 pb-3 border-0">Date</th>
                                    <th class="pt-3 pb-3 border-0">Name</th>
                                    <th class="pt-3 pb-3 border-0">Email/Phone</th>
                                    <th class="pt-3 pb-3 border-0">Message</th>
                                    <th class="pt-3 pb-3 border-0 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages as $message)
                                <tr>
                                    <td class="py-3">
                                        <div class="fw-bold">{{ $message->created_at->format('d M, Y') }}</div>
                                        <small class="text-muted">{{ $message->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; color: #6366f1;">
                                                <i data-feather="user" style="width: 16px;"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $message->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div><i data-feather="mail" class="me-1" style="width: 14px;"></i> {{ $message->email ?? 'N/A' }}</div>
                                        <div><i data-feather="phone" class="me-1" style="width: 14px;"></i> {{ $message->phone ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-3">
                                        <div style="max-width: 300px; white-space: normal; line-height: 1.5;">
                                            {{ $message->message }}
                                        </div>
                                    </td>
                                    <td class="py-3 text-end">
                                        <form action="{{ route('admin.messages.destroy', ['tenant' => $tenant, 'id' => $message->id]) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই মেসেজটি ডিলিট করতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;">
                                                <i data-feather="trash-2" style="width: 14px;"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted mb-3">
                                            <i data-feather="inbox" style="width: 48px; height: 48px; opacity: 0.2;"></i>
                                        </div>
                                        <h5>No messages found yet.</h5>
                                        <p class="small text-muted">When someone submits the contact form on your website, it will appear here.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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