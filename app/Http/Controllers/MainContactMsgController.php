<?php

namespace App\Http\Controllers;

use App\Models\MainContactMsg;
use Illuminate\Http\Request;

class MainContactMsgController extends Controller
{
    public function index()
    {
        $messages = MainContactMsg::latest()->paginate(20);
        return view('super.contact_messages.index', compact('messages'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        MainContactMsg::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'school_name' => $request->school_name,
            'message' => $request->message,
        ]);

        return back()->with('success', 'আপনার মেসেজটি সফলভাবে পাঠানো হয়েছে। আমরা দ্রুত আপনার সাথে যোগাযোগ করব।');
    }

    public function show($id)
    {
        $message = MainContactMsg::findOrFail($id);
        $message->update(['is_read' => true]);
        return view('super.contact_messages.show', compact('message'));
    }
    public function destroy($id)
    {
        MainContactMsg::findOrFail($id)->delete();
        return redirect()->route('manage.contact.index')->with('success', 'Message deleted successfully!');
    }
}
