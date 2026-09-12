<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::with(['school', 'user', 'replies']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhereHas('school', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'    => SupportTicket::count(),
            'open'     => SupportTicket::where('status', 'open')->count(),
            'pending'  => SupportTicket::where('status', 'pending')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
            'closed'   => SupportTicket::where('status', 'closed')->count(),
            'unread'   => SupportTicket::where('is_read_by_super', false)->count(),
        ];

        return view('super.support.index', compact('tickets', 'stats'));
    }

    public function show($id)
    {
        $ticket = SupportTicket::with(['school', 'replies.user', 'user'])->findOrFail($id);
        
        foreach($ticket->replies as $reply) {
            // A reply is from the school side if the user has any school_id (since super admins have NULL)
            $reply->is_school_side = !is_null($reply->user->school_id);
        }
        
        $ticket->update(['is_read_by_super' => true]);
        
        return view('super.support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:5120',
        ]);
        
        $ticket = SupportTicket::findOrFail($id);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('support/attachments', 'public');
        }
        
        $reply = SupportReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'attachment' => $attachmentPath,
        ]);

        $ticket->update([
            'status' => 'pending',
            'is_read_by_school' => false,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply sent!',
                'data' => [
                    'id' => $reply->id,
                    'user_name' => Auth::user()->name,
                    'message' => $reply->message,
                    'attachment' => $reply->attachment ? asset('storage/' . $reply->attachment) : null,
                    'time' => $reply->created_at->format('d M, h:i A'),
                    'is_school_side' => false
                ]
            ]);
        }

        return back()->with('success', 'Reply sent to school admin!');
    }

    public function fetchReplies($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $last_id = request('last_id', 0);
        
        $replies = SupportReply::with('user')
            ->where('ticket_id', $id)
            ->where('id', '>', $last_id)
            ->get();
            
        $data = $replies->map(function($reply) use ($ticket) {
            return [
                'id' => $reply->id,
                'user_name' => $reply->user->name,
                'message' => $reply->message,
                'attachment' => $reply->attachment ? asset('storage/' . $reply->attachment) : null,
                'time' => $reply->created_at->format('d M, h:i A'),
                'is_school_side' => !is_null($reply->user->school_id)
            ];
        });
        
        return response()->json(['data' => $data]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:open,pending,resolved,closed']);
        $ticket = SupportTicket::findOrFail($id);
        $ticket->update(['status' => $request->status]);
        
        return back()->with('success', 'Ticket status updated!');
    }

    public function destroy($id)
    {
        SupportTicket::findOrFail($id)->delete();
        return redirect()->route('manage.support.index')->with('success', 'Ticket deleted successfully!');
    }
}
