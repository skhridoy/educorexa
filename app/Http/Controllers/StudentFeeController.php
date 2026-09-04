<?php

namespace App\Http\Controllers;

use App\Models\FeeHead;
use App\Models\StudentFee;
use App\Models\FeeAmount;
use App\Models\Student;
use App\Models\Classes;
use App\Models\SchoolCategory;
use App\Models\SchoolSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentFeeController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $feeHeads = FeeHead::where('school_id', $schoolId)->get();
        $classes = Classes::where('school_id', $schoolId)->get();
        
        // ভিউতে ক্যাটেগরি পাঠানোর জন্য
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        
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

        return view('school.fee-manage.student-fee.index', compact('feeHeads', 'recentGenerations', 'classes', 'categories'));
    }

    public function getSubCategories($tenant, $categoryId)
    {
        // স্কুল আইডি এবং ক্যাটেগরি আইডি অনুযায়ী সাব-ক্যাটেগরি ফিল্টার
        $subCategories = SchoolSubCategory::where('school_id', auth()->user()->school_id)
                            ->where('school_category_id', $categoryId)
                            ->get(['id', 'name']);

        return response()->json($subCategories);
    }
    public function store(Request $request)
    {
        $request->validate([
            'fee_head_id'            => 'required',
            'month'                  => 'required',
            'school_category_id'     => 'nullable',
            'school_sub_category_id' => 'nullable',
            'class_id'               => 'nullable',
        ]);

        $schoolId = auth()->user()->school_id;

        // ১. ওই স্কুলের ফি হেডের জন্য কোনো অ্যামাউন্ট কনফিগারেশন আছে কিনা চেক করা
        $feeAmountsQuery = FeeAmount::where('school_id', $schoolId)
            ->where('fee_head_id', $request->fee_head_id);

        if ($request->filled('school_category_id')) {
            $feeAmountsQuery->where('school_category_id', $request->school_category_id);
        }

        if ($request->filled('school_sub_category_id')) {
            $feeAmountsQuery->where('school_sub_category_id', $request->school_sub_category_id);
        }

        if ($request->filled('class_id')) {
            $feeAmountsQuery->where('class_id', $request->class_id);
        }

        $feeSetups = $feeAmountsQuery->get();

        if ($feeSetups->isEmpty()) {
            return back()->with('error', 'এই ফি হেডের জন্য নির্বাচিত ফিল্টারে কোনো ফি স্ট্রাকচার/অ্যামাউন্ট সেট করা নেই! প্রথমে "Setup Fee Amounts" থেকে ফি সেট করুন।');
        }

        // ২. ডিউ ডেট গণনা
        try {
            $dueDate = \Carbon\Carbon::parse('01-' . $request->month)->endOfMonth()->toDateString();
        } catch (\Exception $e) {
            $dueDate = now()->endOfMonth()->toDateString();
        }

        // ৩. ফি কনফিগারেশনগুলোকে দ্রুত লুকআপের জন্য ইন্ডেক্স করা
        // Priority 1: class_id + sub_category_id
        // Priority 2 (fallback): class_id + general (null sub_category)
        $subCategoryFeeMap = [];
        $generalClassFeeMap = [];

        foreach ($feeSetups as $setup) {
            if ($setup->school_sub_category_id) {
                $subCategoryFeeMap[$setup->class_id][$setup->school_sub_category_id] = $setup;
            } else {
                $generalClassFeeMap[$setup->class_id] = $setup;
            }
        }

        $allConfiguredClassIds = $feeSetups->pluck('class_id')->unique()->toArray();

        // ৪. উপযুক্ত সক্রিয় শিক্ষার্থীদের নিয়ে আসা
        $studentQuery = Student::where('school_id', $schoolId)
            ->where(function ($q) {
                $q->where('status', 'active')
                  ->orWhereNull('status');
            })
            ->whereIn('class_id', $allConfiguredClassIds);

        // ক্যাটেগরি ফিল্টার (স্টুডেন্ট অথবা তার ক্লাসের ক্যাটেগরি চেক করা)
        if ($request->filled('school_category_id')) {
            $categoryId = $request->school_category_id;
            $studentQuery->where(function ($q) use ($categoryId) {
                $q->where('school_category_id', $categoryId)
                  ->orWhereHas('class', function ($cq) use ($categoryId) {
                      $cq->where('school_category_id', $categoryId);
                  });
            });
        }

        // সাব-ক্যাটেগরি (গ্রুপ) ফিল্টার
        if ($request->filled('school_sub_category_id')) {
            $studentQuery->where('school_sub_category_id', $request->school_sub_category_id);
        }

        // ক্লাস ফিল্টার
        if ($request->filled('class_id')) {
            $studentQuery->where('class_id', $request->class_id);
        }

        // ডুপ্লিকেট জেনারেশন রোধ: যে শিক্ষার্থীদের ইতিমধ্যে এই মাসে এই ফি আছে তাদের বাদ দেওয়া
        $students = $studentQuery->whereNotExists(function ($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('student_fees')
                    ->whereColumn('student_fees.student_id', 'students.id')
                    ->where('student_fees.fee_head_id', $request->fee_head_id)
                    ->where('student_fees.month', $request->month);
            })
            ->with(['class'])
            ->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'নির্বাচিত মাস (' . $request->month . ') এর জন্য ফি ইতোমধ্যে তৈরি করা হয়েছে অথবা উপযুক্ত কোনো শিক্ষার্থী পাওয়া যায়নি।');
        }

        // ৫. উপযুক্ত শিক্ষার্থীদের কোনো কনসেশন/মাইনাস ফি সেট করা আছে কিনা নিয়ে আসা
        $studentConcessions = \App\Models\StudentFeeConcession::where('school_id', $schoolId)
            ->where('fee_head_id', $request->fee_head_id)
            ->where('is_active', true)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        $count = 0;
        $now = now();
        $records = [];

        try {
            DB::beginTransaction();

            foreach ($students as $student) {
                $classId = $student->class_id;
                $subCatId = $student->school_sub_category_id;

                // নির্দিষ্ট সাব-ক্যাটেগরি ফি খুঁজুন, না পেলে জেনারেল ক্লাস ফি ব্যবহার করুন
                $applicableSetup = null;
                if ($subCatId && isset($subCategoryFeeMap[$classId][$subCatId])) {
                    $applicableSetup = $subCategoryFeeMap[$classId][$subCatId];
                } elseif (isset($generalClassFeeMap[$classId])) {
                    $applicableSetup = $generalClassFeeMap[$classId];
                } elseif (isset($subCategoryFeeMap[$classId])) {
                    $applicableSetup = reset($subCategoryFeeMap[$classId]);
                }

                if (!$applicableSetup) {
                    continue;
                }

                $categoryId = $student->school_category_id ?? $student->class?->school_category_id ?? $applicableSetup->school_category_id;
                $standardAmount = (float) $applicableSetup->amount;
                $finalAmount = $standardAmount;
                $discountAmount = 0.00;
                $discountPercent = 0.00;
                $discountNote = null;

                // যদি শিক্ষার্থীর জন্য মাইনাস ফি / ছাড় কনফিগার করা থাকে
                if (isset($studentConcessions[$student->id])) {
                    $calc = $studentConcessions[$student->id]->calculateFee($standardAmount);
                    $finalAmount = $calc['final_amount'];
                    $discountAmount = $calc['discount_amount'];
                    $discountPercent = $calc['discount_percent'];
                    $discountNote = $studentConcessions[$student->id]->note ?: 'Student custom fee concession';
                }

                $records[] = [
                    'school_id'              => $schoolId,
                    'student_id'             => $student->id,
                    'school_category_id'     => $categoryId,
                    'school_sub_category_id' => $student->school_sub_category_id ?? $applicableSetup->school_sub_category_id,
                    'fee_head_id'            => $request->fee_head_id,
                    'amount'                 => $finalAmount,
                    'original_amount'        => $standardAmount,
                    'discount_amount'        => $discountAmount,
                    'discount_percent'       => $discountPercent,
                    'discount_note'          => $discountNote,
                    'month'                  => $request->month,
                    'status'                 => 'unpaid',
                    'due_date'               => $dueDate,
                    'fee_type_limit'         => 'global',
                    'created_at'             => $now,
                    'updated_at'             => $now,
                ];

                $count++;

                // Chunked insert for efficiency
                if (count($records) >= 250) {
                    StudentFee::insert($records);
                    $records = [];
                }
            }

            if (!empty($records)) {
                StudentFee::insert($records);
            }

            DB::commit();

            if ($count === 0) {
                return back()->with('error', 'কোনো শিক্ষার্থীর জন্য ফি নির্ধারণ করা যায়নি। অনুগ্রহ করে ফি সেটআপ পরীক্ষা করুন।');
            }

            return redirect()->back()->with('success', $count . ' জন শিক্ষার্থীর ফি বিল সফলভাবে তৈরি হয়েছে।');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'ফি তৈরিতে ত্রুটি হয়েছে: ' . $e->getMessage());
        }
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