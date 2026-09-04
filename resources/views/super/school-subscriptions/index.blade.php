@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title">Manual Subscription Payments</h2>
            <p class="edu-page-sub">Verify bKash and Nagad personal account transaction submissions.</p>
        </div>
        <span class="badge-amber">{{ $subscriptions->count() }} Pending</span>
    </div>

    <div class="edu-panel">
        <div class="table-responsive">
            <table class="edu-table">
                <thead>
                    <tr>
                        <th>School</th>
                        <th>Package</th>
                        <th>Method</th>
                        <th>Sender</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->school->name }}</td>
                            <td>{{ $subscription->package->name }}</td>
                            <td>{{ strtoupper($subscription->payment_method) }}</td>
                            <td>{{ $subscription->sender_number }}</td>
                            <td><strong>{{ $subscription->payment_reference }}</strong></td>
                            <td>৳{{ number_format($subscription->amount, 2) }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('super.subscription-payments.approve', $subscription) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success" type="submit">Verify & Activate</button>
                                    </form>
                                    <form action="{{ route('super.subscription-payments.reject', $subscription) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="rejection_reason" value="Payment details could not be verified.">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="edu-empty"><p>No payment submissions waiting for verification.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
