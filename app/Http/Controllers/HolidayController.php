<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HolidayController extends Controller
{
    // ছুটির দিনের তালিকা দেখানো
    public function index($tenant)
    {
        $holidays = Holiday::where('school_id', auth()->user()->school_id)
                            ->orderBy('date', 'asc')
                            ->paginate(15);

        return view('school.holidays.index', compact('holidays', 'tenant'));
    }

    // ছুটি সেভ করা
    public function store(Request $request, $tenant)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date'  => 'required|date',
        ]);

        try {
            Holiday::create([
                'school_id' => auth()->user()->school_id,
                'title'     => $request->title,
                'date'      => $request->date,
            ]);

            return redirect()->back()->with('success', 'Holiday added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // ছুটি ডিলিট করা
    public function destroy($tenant, $id)
    {
        $holiday = Holiday::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $holiday->delete();

        return redirect()->back()->with('success', 'Holiday deleted successfully!');
    }
}