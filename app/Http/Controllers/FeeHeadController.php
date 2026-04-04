<?php 

namespace App\Http\Controllers;

use App\Models\FeeHead;
use Illuminate\Http\Request;

class FeeHeadController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $feeHeads = FeeHead::where('school_id', $schoolId)->latest()->get();
        return view('school.fee-manage.fee-head.index', compact('feeHeads'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate([
            'name' => 'required|string|max:255'.$schoolId,
            'type' => 'required|in:monthly,once,recurring',
        ]);


        FeeHead::create([
            'school_id' => $schoolId,
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->back()->with(['success' => 'Fee Head created successfully', 'type' => 'success']);
    }

    // Resource রাউটে 'edit' মেথডটি অপশনাল (যদি আপনি মডাল ব্যবহার না করেন)
    public function edit($tenant, $fee_head)
    {
        $schoolId = auth()->user()->school_id;
        $feeHeads = FeeHead::where('school_id', $schoolId)->get();

        $fee_head = FeeHead::where('id', $fee_head)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();
        return view('school.fee-manage.fee-head.edit', compact('fee_head', 'feeHeads'));
    }

    public function update(Request $request, $tenant, $fee_head)
    {
        $schoolId = auth()->user()->school_id;

        $fee_head = FeeHead::where('id', $fee_head)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        $fee_head->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);
        $fee_head->update($request->only('name', 'type'));

        return redirect()->back()->with(['success' => 'Fee head updated successfully', 'type' => 'success']);
    }

    public function destroy($tenant, $fee_heads)
    {
        $schoolId = auth()->user()->school_id; 
        $fee_heads = FeeHead::where('id', $fee_heads)
                                    ->where('school_id', $schoolId)
                                    ->firstOrFail();
        $fee_heads->delete();
        return redirect()->back()->with(['success' => 'Fee head deleted successfully', 'type' => 'warning']);
    }
}