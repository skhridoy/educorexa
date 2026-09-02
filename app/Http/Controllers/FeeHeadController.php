<?php 

namespace App\Http\Controllers;

use App\Models\FeeHead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                'string',
                'max:255',
                // শুধুমাত্র এই স্কুলের অধীনে নাম ইউনিক কিনা চেক করবে
                Rule::unique('fee_heads')->where(function ($query) use ($schoolId) {
                    return $query->where('school_id', $schoolId);
                }),
            ],
            'type' => 'required|in:monthly,once,recurring',
        ]);

        FeeHead::create([
            'school_id' => $schoolId,
            'name'      => $request->name,
            'type'      => $request->type,
        ]);

        return redirect()->back()->with(['success' => 'Fee Head created successfully', 'type' => 'success']);
    }

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

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // আপডেট করার সময় নিজের ID বাদ দিয়ে স্কুলের অন্য নামে ইউনিক চেক করবে
                Rule::unique('fee_heads')->where(function ($query) use ($schoolId) {
                    return $query->where('school_id', $schoolId);
                })->ignore($fee_head->id),
            ],
            'type' => 'required|in:monthly,once,recurring',
        ]);

        $fee_head->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

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