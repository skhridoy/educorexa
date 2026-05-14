<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('school')->latest()->paginate(20);
        return view('super.support.index', compact('tickets'));
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
        return redirect()->route('super.support.index')->with('success', 'Ticket deleted successfully!');
    }
}
