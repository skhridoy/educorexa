<?php

namespace App\Http\Controllers;

use App\Models\FeeHead;
use App\Models\FeeAmount;
use App\Models\Student;
use App\Models\Classes;
use App\Models\StudentFee;
use App\Models\StudentFeeConcession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentFeeConcessionController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        // Active Concessions query for listing table
        $query = StudentFeeConcession::with(['student.class', 'student.section', 'feeHead'])
            ->where('school_id', $schoolId);

        if ($request->filled('class_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('roll', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fee_head_id')) {
            $query->where('fee_head_id', $request->fee_head_id);
        }

        $concessionsList = $query->latest('id')->paginate(15)->withQueryString();

        // Stats
        $totalDiscountedStudents = StudentFeeConcession::where('school_id', $schoolId)
            ->where('is_active', true)
            ->distinct('student_id')
            ->count('student_id');

        $activeConcessionsCount = StudentFeeConcession::where('school_id', $schoolId)
            ->where('is_active', true)
            ->count();

        $totalDiscountAmountGiven = StudentFee::where('school_id', $schoolId)->sum('discount_amount');

        // Optional selected student for concession setup
        $student = null;
        $studentConcessions = collect();
        $standardFeeAmounts = collect();

        if ($request->filled('student_id')) {
            $student = Student::with(['class', 'section'])
                ->where('school_id', $schoolId)
                ->where(function ($q) use ($request) {
                    $q->where('student_id', $request->student_id)
                      ->orWhere('id', $request->student_id);
                })
                ->first();

            if ($student) {
                $studentConcessions = StudentFeeConcession::where('school_id', $schoolId)
                    ->where('student_id', $student->id)
                    ->get()
                    ->keyBy('fee_head_id');

                $standardFeeAmounts = FeeAmount::where('school_id', $schoolId)
                    ->where('class_id', $student->class_id)
                    ->get()
                    ->keyBy('fee_head_id');
            }
        }

        $classes = Classes::where('school_id', $schoolId)->get();
        $feeHeads = FeeHead::where('school_id', $schoolId)->get();
        $allStandardFeeAmounts = FeeAmount::where('school_id', $schoolId)->get()->keyBy(function($item) {
            return $item->class_id . '_' . $item->fee_head_id;
        });

        return view('school.fee-manage.concession.index', compact(
            'concessionsList',
            'totalDiscountedStudents',
            'activeConcessionsCount',
            'totalDiscountAmountGiven',
            'student',
            'studentConcessions',
            'standardFeeAmounts',
            'allStandardFeeAmounts',
            'classes',
            'feeHeads'
        ));
    }

    /**
     * Search student by student_id or name via AJAX and return standard fees & current concessions
     */
    public function searchStudent(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $search = $request->query('query');

        if (!$search) {
            return response()->json(['success' => false, 'message' => 'Query string is required'], 400);
        }

        $student = Student::with(['class', 'section', 'category', 'group'])
            ->where('school_id', $schoolId)
            ->where(function ($q) use ($search) {
                $q->where('student_id', $search)
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('contact_number', $search);
            })
            ->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'কোনো শিক্ষার্থী পাওয়া যায়নি (No student found with ID: ' . $search . ')'
            ], 404);
        }

        // Get all Fee Heads of the school
        $feeHeads = FeeHead::where('school_id', $schoolId)->get();

        // Get standard Fee Amounts for student's class
        $feeAmounts = FeeAmount::where('school_id', $schoolId)
            ->where('class_id', $student->class_id)
            ->get()
            ->keyBy('fee_head_id');

        // Get existing concessions for this student
        $existingConcessions = StudentFeeConcession::where('school_id', $schoolId)
            ->where('student_id', $student->id)
            ->get()
            ->keyBy('fee_head_id');

        // Build detailed list of heads with standard amount and current concession
        $headDetails = [];
        foreach ($feeHeads as $head) {
            $stdAmount = isset($feeAmounts[$head->id]) ? (float) $feeAmounts[$head->id]->amount : 0.00;
            $concession = $existingConcessions[$head->id] ?? null;

            $headDetails[] = [
                'fee_head_id'     => $head->id,
                'fee_head_name'   => $head->name,
                'standard_amount' => $stdAmount,
                'has_concession'  => $concession !== null,
                'discount_type'   => $concession?->discount_type ?? 'fixed_amount',
                'discount_amount' => $concession ? (float) $concession->discount_amount : 0.00,
                'discount_percent'=> $concession ? (float) $concession->discount_percent : 0.00,
                'custom_amount'   => $concession ? (float) $concession->custom_amount : null,
                'note'            => $concession?->note ?? '',
                'is_active'       => $concession ? $concession->is_active : true,
            ];
        }

        $unpaidCount = StudentFee::where('school_id', $schoolId)
            ->where('student_id', $student->id)
            ->where('status', 'unpaid')
            ->count();

        return response()->json([
            'success' => true,
            'student' => [
                'id'             => $student->id,
                'student_id'     => $student->student_id,
                'name'           => $student->name,
                'roll'           => $student->roll,
                'class_name'     => $student->class->name ?? '—',
                'section_name'   => $student->section->name ?? '—',
                'photo'          => $student->photo ? asset($student->photo) : asset('assets/images/profile.webp'),
                'contact_number' => $student->contact_number,
                'unpaid_count'   => $unpaidCount,
            ],
            'fee_heads' => $headDetails,
        ]);
    }

    /**
     * Store or update student fee concession(s)
     */
    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'concessions' => 'nullable|array',
            'fee_head_id' => 'nullable|exists:fee_heads,id',
        ]);

        $student = Student::where('school_id', $schoolId)->findOrFail($request->student_id);
        $applyToUnpaid = $request->boolean('apply_to_existing_unpaid') || $request->boolean('apply_to_unpaid');
        $reason = $request->reason ?? $request->note;

        DB::beginTransaction();
        try {
            // Case 1: Batch submission from form table
            if ($request->filled('concessions') && is_array($request->concessions)) {
                foreach ($request->concessions as $headId => $cData) {
                    $discountType = $cData['discount_type'] ?? 'fixed_amount';
                    $val = floatval($cData['discount_value'] ?? 0);

                    // If value is 0 or empty, delete any existing concession if user removed it
                    if ($val <= 0) {
                        StudentFeeConcession::where('school_id', $schoolId)
                            ->where('student_id', $student->id)
                            ->where('fee_head_id', $headId)
                            ->delete();
                        continue;
                    }

                    $discountAmount = 0;
                    $discountPercent = 0;
                    $customAmount = null;

                    $stdSetup = FeeAmount::where('school_id', $schoolId)
                        ->where('class_id', $student->class_id)
                        ->where('fee_head_id', $headId)
                        ->first();
                    $standardAmount = $stdSetup ? (float) $stdSetup->amount : 0.00;

                    if ($discountType === 'percentage') {
                        $discountPercent = min(100, $val);
                        $discountAmount = round($standardAmount * ($discountPercent / 100), 2);
                        $customAmount = max(0, $standardAmount - $discountAmount);
                    } elseif ($discountType === 'custom_fee') {
                        $customAmount = $val;
                        $discountAmount = max(0, $standardAmount - $customAmount);
                        $discountPercent = $standardAmount > 0 ? round(($discountAmount / $standardAmount) * 100, 2) : 0;
                    } else { // fixed_amount
                        $discountAmount = min($standardAmount, $val);
                        $discountPercent = $standardAmount > 0 ? round(($discountAmount / $standardAmount) * 100, 2) : 0;
                        $customAmount = max(0, $standardAmount - $discountAmount);
                    }

                    $concession = StudentFeeConcession::updateOrCreate(
                        [
                            'school_id'   => $schoolId,
                            'student_id'  => $student->id,
                            'fee_head_id' => $headId,
                        ],
                        [
                            'discount_type'    => $discountType,
                            'discount_amount'  => $discountAmount,
                            'discount_percent' => $discountPercent,
                            'custom_amount'    => $customAmount,
                            'note'             => $reason,
                            'is_active'        => true,
                        ]
                    );

                    if ($applyToUnpaid) {
                        $unpaidFees = StudentFee::where('school_id', $schoolId)
                            ->where('student_id', $student->id)
                            ->where('fee_head_id', $headId)
                            ->where('status', 'unpaid')
                            ->get();

                        foreach ($unpaidFees as $fee) {
                            $orig = ($fee->original_amount && $fee->original_amount > 0) ? (float) $fee->original_amount : (float) $fee->amount;
                            $calc = $concession->calculateFee($orig);

                            $fee->update([
                                'original_amount'  => $orig,
                                'discount_amount'  => $calc['discount_amount'],
                                'discount_percent' => $calc['discount_percent'],
                                'amount'           => $calc['final_amount'],
                                'discount_note'    => $reason ?: 'Special fee concession applied',
                            ]);
                        }
                    }
                }
            } elseif ($request->filled('fee_head_id')) {
                // Case 2: Single concession submission (e.g. via modal or API)
                $feeHead = FeeHead::where('school_id', $schoolId)->findOrFail($request->fee_head_id);
                $discountType = $request->discount_type ?? 'fixed_amount';
                $discountAmount = (float) ($request->discount_amount ?? 0);
                $discountPercent = (float) ($request->discount_percent ?? 0);
                $customAmount = $request->filled('custom_amount') ? (float) $request->custom_amount : null;

                $stdSetup = FeeAmount::where('school_id', $schoolId)
                    ->where('class_id', $student->class_id)
                    ->where('fee_head_id', $feeHead->id)
                    ->first();
                $standardAmount = $stdSetup ? (float) $stdSetup->amount : 0.00;

                if ($discountType === 'custom_fee' && $customAmount !== null) {
                    $discountAmount = max(0, $standardAmount - $customAmount);
                    $discountPercent = $standardAmount > 0 ? round(($discountAmount / $standardAmount) * 100, 2) : 0;
                } elseif ($discountType === 'percentage' && $discountPercent > 0) {
                    $discountAmount = round($standardAmount * ($discountPercent / 100), 2);
                    $customAmount = max(0, $standardAmount - $discountAmount);
                } elseif ($discountType === 'fixed_amount' && $discountAmount > 0) {
                    $discountPercent = $standardAmount > 0 ? round(($discountAmount / $standardAmount) * 100, 2) : 0;
                    $customAmount = max(0, $standardAmount - $discountAmount);
                }

                $concession = StudentFeeConcession::updateOrCreate(
                    [
                        'school_id'   => $schoolId,
                        'student_id'  => $student->id,
                        'fee_head_id' => $feeHead->id,
                    ],
                    [
                        'discount_type'    => $discountType,
                        'discount_amount'  => $discountAmount,
                        'discount_percent' => $discountPercent,
                        'custom_amount'    => $customAmount,
                        'note'             => $reason,
                        'is_active'        => true,
                    ]
                );

                if ($applyToUnpaid) {
                    $unpaidFees = StudentFee::where('school_id', $schoolId)
                        ->where('student_id', $student->id)
                        ->where('fee_head_id', $feeHead->id)
                        ->where('status', 'unpaid')
                        ->get();

                    foreach ($unpaidFees as $fee) {
                        $orig = ($fee->original_amount && $fee->original_amount > 0) ? (float) $fee->original_amount : (float) $fee->amount;
                        $calc = $concession->calculateFee($orig);

                        $fee->update([
                            'original_amount'  => $orig,
                            'discount_amount'  => $calc['discount_amount'],
                            'discount_percent' => $calc['discount_percent'],
                            'amount'           => $calc['final_amount'],
                            'discount_note'    => $reason ?: 'Special fee concession applied',
                        ]);
                    }
                }
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'শিক্ষার্থীর ফি ছাড় (মাইনাস ফি) সফলভাবে সংরক্ষণ করা হয়েছে!',
                ]);
            }

            return back()->with([
                'success' => 'শিক্ষার্থীর ফি ছাড় (মাইনাস ফি) সফলভাবে সংরক্ষণ করা হয়েছে!',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with([
                'success' => 'সংরক্ষণে সমস্যা হয়েছে: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Update an existing student fee concession
     */
    public function update(Request $request, $tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $concession = StudentFeeConcession::with(['student', 'feeHead'])
            ->where('school_id', $schoolId)
            ->findOrFail($id);

        $request->validate([
            'discount_type' => 'required|in:fixed_amount,percentage,custom_fee',
            'discount_value' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'apply_to_existing_unpaid' => 'nullable|boolean',
        ]);

        $discountType = $request->discount_type;
        $val = floatval($request->discount_value);
        $student = $concession->student;
        $feeHead = $concession->feeHead;

        $stdSetup = FeeAmount::where('school_id', $schoolId)
            ->where('class_id', $student->class_id)
            ->where('fee_head_id', $feeHead->id)
            ->first();
        $standardAmount = $stdSetup ? (float) $stdSetup->amount : 0.00;

        $discountAmount = 0;
        $discountPercent = 0;
        $customAmount = null;

        if ($discountType === 'percentage') {
            $discountPercent = min(100, $val);
            $discountAmount = round($standardAmount * ($discountPercent / 100), 2);
            $customAmount = max(0, $standardAmount - $discountAmount);
        } elseif ($discountType === 'custom_fee') {
            $customAmount = $val;
            $discountAmount = max(0, $standardAmount - $customAmount);
            $discountPercent = $standardAmount > 0 ? round(($discountAmount / $standardAmount) * 100, 2) : 0;
        } else { // fixed_amount
            $discountAmount = min($standardAmount, $val);
            $discountPercent = $standardAmount > 0 ? round(($discountAmount / $standardAmount) * 100, 2) : 0;
            $customAmount = max(0, $standardAmount - $discountAmount);
        }

        DB::beginTransaction();
        try {
            $concession->update([
                'discount_type' => $discountType,
                'discount_amount' => $discountAmount,
                'discount_percent' => $discountPercent,
                'custom_amount' => $customAmount,
                'note' => $request->note,
                'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
            ]);

            if ($request->boolean('apply_to_existing_unpaid')) {
                $unpaidFees = StudentFee::where('school_id', $schoolId)
                    ->where('student_id', $student->id)
                    ->where('fee_head_id', $feeHead->id)
                    ->where('status', 'unpaid')
                    ->get();

                foreach ($unpaidFees as $fee) {
                    $orig = ($fee->original_amount && $fee->original_amount > 0) ? (float) $fee->original_amount : (float) $fee->amount;
                    $calc = $concession->calculateFee($orig);

                    $fee->update([
                        'original_amount' => $orig,
                        'discount_amount' => $calc['discount_amount'],
                        'discount_percent' => $calc['discount_percent'],
                        'amount' => $calc['final_amount'],
                        'discount_note' => $request->note ?: 'Fee concession updated',
                    ]);
                }
            }

            DB::commit();

            return back()->with([
                'success' => 'শিক্ষার্থীর ফি ছাড় সফলভাবে আপডেট করা হয়েছে!',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'success' => 'আপডেটে সমস্যা হয়েছে: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Remove a student fee concession
     */
    public function destroy($tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $concession = StudentFeeConcession::where('school_id', $schoolId)->findOrFail($id);
        $concession->delete();

        return back()->with([
            'success' => 'ফি ছাড় সংক্রান্ত রেকর্ড সফলভাবে মুছে ফেলা হয়েছে।',
            'type' => 'success'
        ]);
    }
}
