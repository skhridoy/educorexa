<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SchoolSupportController extends Controller
{
    public function index($tenant)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
        if (!$school) abort(404);

        $tickets = SupportTicket::where('school_id', $school->id)
            ->latest()
            ->paginate(10);

        return view('school.support.index', compact('tickets', 'tenant'));
    }

    public function create($tenant)
    {
        return view('school.support.create', compact('tenant'));
    }

    public function store(Request $request, $tenant)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:5120', // 5MB max
        ]);

        $school = DB::table('schools')->where('slug', $tenant)->first();
        
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('support/attachments', 'public');
        }

        SupportTicket::create([
            'school_id' => $school->id,
            'user_id' => Auth::id(),
            'ticket_id' => 'TIC-' . strtoupper(Str::random(8)),
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => 'open',
            'is_read_by_super' => false,
            'is_read_by_school' => true,
            'attachment' => $attachmentPath,
        ]);

        return redirect()->route('school.support.index', $tenant)->with('success', 'Support ticket created successfully!');
    }

    public function show($tenant, $id)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
        $ticket = SupportTicket::with('replies.user')->where('school_id', $school->id)->findOrFail($id);
        
        foreach($ticket->replies as $reply) {
            // A reply is from the school side if the user has the same school_id as the ticket
            $reply->is_school_side = ($reply->user->school_id == $ticket->school_id);
        }
        
        $ticket->update(['is_read_by_school' => true]);

        return view('school.support.show', compact('ticket', 'tenant'));
    }

    public function reply(Request $request, $tenant, $id)
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
            'status' => 'open',
            'is_read_by_super' => false,
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
                    'is_school_side' => true
                ]
            ]);
        }

        return back()->with('success', 'Reply sent successfully!');
    }

    public function fetchReplies($tenant, $id)
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
                'is_school_side' => ($reply->user->school_id == $ticket->school_id)
            ];
        });
        
        return response()->json(['data' => $data]);
    }
}
