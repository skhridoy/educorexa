<?php

namespace App\Http\Controllers;

use App\Models\InboundMessage;
use App\Models\School;
use App\Services\InboundMailService;
use Illuminate\Http\Request;

class InboundMessageController extends Controller
{
    public function webhook(Request $request, InboundMailService $service)
    {
        if (!$service->isAuthorized($request->all(), $request->header('X-Inbound-Mail-Secret'))) {
            abort(403);
        }

        $message = $service->store($request->all());
        return response()->json(['accepted' => (bool) $message]);
    }

    public function schoolIndex(string $tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        $messages = InboundMessage::where('school_id', $school->id)->latest('received_at')->latest()->paginate(20);
        return view('school.inbox.index', compact('messages', 'school'));
    }

    public function superIndex(Request $request)
    {
        $messages = InboundMessage::with('school')->when($request->mailbox, fn ($q, $mailbox) => $q->where('mailbox_type', $mailbox))
            ->latest('received_at')->latest()->paginate(25)->withQueryString();
        return view('super.inbox.index', compact('messages'));
    }

    public function show(Request $request, int $id)
    {
        $message = $this->queryForUser($request, $id)->firstOrFail();
        $message->update(['is_read' => true]);
        return view($this->isSuperAdmin() ? 'super.inbox.show' : 'school.inbox.show', compact('message'));
    }

    public function update(Request $request, int $id)
    {
        $message = $this->queryForUser($request, $id)->firstOrFail();
        $message->update($request->validate(['status' => 'required|in:open,pending,resolved,spam']));
        return back()->with('success', 'Email status updated.');
    }

    public function destroy(Request $request, int $id)
    {
        $this->queryForUser($request, $id)->firstOrFail()->delete();
        return back()->with('success', 'Email deleted.');
    }

    private function queryForUser(Request $request, int $id)
    {
        $query = InboundMessage::query()->whereKey($id);
        if (!$this->isSuperAdmin()) {
            $query->where('school_id', auth()->user()->school_id);
        }
        return $query;
    }

    private function isSuperAdmin(): bool
    {
        return auth()->user()->hasRole('super_admin') || auth()->user()->role === 'super_admin';
    }
}
