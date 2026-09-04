<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSubscription;
use App\Services\SubscriptionBillingService;
use Illuminate\Http\Request;

class SchoolSubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = SchoolSubscription::with(['school', 'package'])
            ->where('status', 'pending')
            ->whereNotNull('payment_reference')
            ->latest('payment_submitted_at')
            ->get();

        return view('super.school-subscriptions.index', compact('subscriptions'));
    }

    public function approve(Request $request, SchoolSubscription $subscription)
    {
        abort_unless($subscription->status === 'pending' && $subscription->payment_reference, 404);

        app(SubscriptionBillingService::class)->markPaid(
            $subscription->load('package', 'school'),
            $subscription->payment_reference
        );

        return back()->with('success', 'Payment verified and package activated successfully.');
    }

    public function reject(Request $request, SchoolSubscription $subscription)
    {
        abort_unless($subscription->status === 'pending' && $subscription->payment_reference, 404);

        $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $subscription->update([
            'status' => 'cancelled',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Payment submission rejected.');
    }
}
