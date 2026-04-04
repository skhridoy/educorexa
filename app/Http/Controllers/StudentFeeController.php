<?php

namespace App\Http\Controllers;

use App\Models\FeeHead;
use App\Models\StudentFee;
use App\Models\FeeAmount;
use App\Models\Student;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentFeeController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $feeHeads = FeeHead::where('school_id', $schoolId)->get();
        
        $classes = Classes::where('school_id', $schoolId)->get();
        $recentGenerations = StudentFee::with('feeHead')
            ->where('school_id', $schoolId)
            ->select(
                DB::raw('MAX(id) as id'),
                'fee_head_id', 
                'month', 
                DB::raw('count(*) as total_students'), 
                DB::raw('sum(amount) as total_amount')
            )
            ->groupBy('fee_head_id', 'month')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return view('school.fee-manage.student-fee.index', compact('feeHeads', 'recentGenerations', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fee_head_id' => 'required',
            'month' => 'required',
        ]);

        $schoolId = auth()->user()->school_id;
        $feeSetups = FeeAmount::where('school_id', $schoolId)
                        ->where('fee_head_id', $request->fee_head_id)
                        ->get();

        if ($feeSetups->isEmpty()) {
            return back()->with('error', 'এই ফি হেডের জন্য কোনো অ্যামাউন্ট সেট করা নেই!');
        }

        $count = 0;
        
        DB::transaction(function () use ($feeSetups, $request, $schoolId, &$count) {
            foreach ($feeSetups as $setup) {
                
                $students = Student::where('school_id', $schoolId)
                    ->where('class_id', $setup->class_id)
                    ->whereNotExists(function ($query) use ($request) {
                        $query->select(DB::raw(1))
                            ->from('student_fees')
                            ->whereColumn('student_fees.student_id', 'students.id')
                            ->where('student_fees.fee_head_id', $request->fee_head_id)
                            ->where('student_fees.month', $request->month);
                    })
                    ->get();

                foreach ($students as $student) {
                    StudentFee::create([
                        'school_id'   => $schoolId,
                        'student_id'  => $student->id,
                        'fee_head_id' => $request->fee_head_id,
                        'amount'      => $setup->amount,
                        'month'       => $request->month,
                        'status'      => 'unpaid',
                        'due_date'    => now()->endOfMonth()->toDateString(),
                    ]);
                    $count++;
                }
            }
        });

        return redirect()->back()->with('success', $count . ' Students Fee Invoice Generated successfully');
    }

    public function destroy($tenant, $id)
    {
        try {
            DB::beginTransaction();

            // ১. রেফারেন্স আইডি দিয়ে ঐ নির্দিষ্ট গ্রুপটি খুঁজে বের করুন
            $referenceFee = StudentFee::where('school_id', auth()->user()->school_id)
                ->findOrFail($id);

            // ২. এই গ্রুপের সকল 'unpaid' ফি ডিলিট করুন
            $deletedCount = StudentFee::where('school_id', auth()->user()->school_id)
                ->where('fee_head_id', $referenceFee->fee_head_id)
                ->where('month', $referenceFee->month)
                ->where('status', 'unpaid') // পেইড ফি ডিলিট হবে না
                ->delete();

            if ($deletedCount == 0) {
                throw new \Exception("No unpaid fees found to delete. Records might be already paid.");
            }

            DB::commit();
            return redirect()->back()->with('success', 'Unpaid fee records for ' . $referenceFee->month . ' have been deleted.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getStudentList($tenant, Request $request)
    {
        try {
            // স্কুল আইডি নিশ্চিত করা (নিরাপত্তার জন্য)
            $schoolId = auth()->user()->school->id;

            $query = StudentFee::with(['student.class'])
                ->where('school_id', $schoolId)
                ->where('fee_head_id', $request->fee_head_id)
                ->where('month', $request->month);

            // যদি ক্লাস ফিল্টার সিলেক্ট করা থাকে
            if ($request->filled('class_id')) {
                $query->whereHas('student', function($q) use ($request) {
                    $q->where('class_id', $request->class_id);
                });
            }

            $fees = $query->get();

            // ভিউ রেন্ডার করে পাঠানো
            return view('school.fee-manage.student-fee._list_table', compact('fees'))->render();

        } catch (\Exception $e) {
            // এরর হলে ৫০০ স্ট্যাটাস কোড সহ মেসেজ পাঠানো
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}