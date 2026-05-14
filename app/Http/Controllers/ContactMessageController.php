<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class ContactMessageController extends Controller
{
    public function index($tenant)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
        if (!$school) {
            return response()->json(['status' => false, 'message' => 'School not found.'], 404);
        }

        $schoolId = $school->id;

        $messages = ContactMessage::where('school_id', $schoolId)->get();

        return view('school.message.index', compact('messages', 'tenant'));
    }
    public function show($tenant, $id)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
        if (!$school) {
            abort(404);
        }

        $message = ContactMessage::where('school_id', $school->id)->findOrFail($id);
        
        return view('school.message.show', compact('message', 'tenant'));
    }

    public function destroy($tenant, $id) {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        return back()->with('success', 'মেসেজটি সফলভাবে ডিলিট করা হয়েছে।');
    }
}
