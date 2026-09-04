<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSubscription;
use App\Services\SubscriptionBillingService;
use Illuminate\Http\Request;

class SchoolSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');

        $query = SchoolSubscription::with(['school', 'package', 'reviewer'])
            ->whereNotNull('payment_reference');

        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } elseif ($tab === 'approved') {
            $query->where('status', 'active')->whereNotNull('paid_at');
        } elseif ($tab === 'rejected') {
            $query->where('status', 'cancelled');
        }

        $subscriptions = $query->latest('updated_at')->paginate(20)->withQueryString();

        $pendingCount = SchoolSubscription::where('status', 'pending')->whereNotNull('payment_reference')->count();
        $approvedCount = SchoolSubscription::where('status', 'active')->whereNotNull('paid_at')->count();
        $rejectedCount = SchoolSubscription::where('status', 'cancelled')->whereNotNull('payment_reference')->count();
        $totalRevenue = (float) SchoolSubscription::where('status', 'active')->whereNotNull('paid_at')->sum('amount');
        $pendingRevenue = (float) SchoolSubscription::where('status', 'pending')->whereNotNull('payment_reference')->sum('amount');

        return view('super.school-subscriptions.index', compact(
            'subscriptions', 'tab', 'pendingCount', 'approvedCount', 'rejectedCount', 'totalRevenue', 'pendingRevenue'
        ));
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
