<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\FeeHead;
use App\Models\FeeAmount;
use App\Models\Student;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class FeeAmountController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $feeHeads = FeeHead::where('school_id', $schoolId)->get();
        $classes = Classes::where('school_id', $schoolId)->get();
        
        $feeAmounts = FeeAmount::with(['feeHead', 'class'])
            ->where('school_id', $schoolId)
            ->paginate(10);

        return view('school.fee-manage.fee-amount.index', compact('feeHeads', 'classes', 'feeAmounts'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'fee_head_id' => 'required|exists:fee_heads,id',
            'amounts' => 'required|array', // ['class_id' => 'amount']
        ]);

        $schoolId = auth()->user()->school_id;

        foreach ($request->amounts as $classId => $amount) {
            if ($amount != null) {
                FeeAmount::updateOrCreate(
                    [
                        'school_id' => $schoolId,
                        'fee_head_id' => $request->fee_head_id,
                        'class_id' => $classId
                    ],
                    ['amount' => $amount]
                );
            }
        }

        return redirect()->back()->with(['success' => 'Fee Amount Setup successfully', 'type' => 'success']);
    }

    
}
