<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFee;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $student = null;
        $unpaidFees = [];
        $paidFeesGroups = collect(); 
        if ($request->filled('student_id')) {
            $student = Student::where('school_id', $schoolId)
                ->where('student_id', $request->student_id)
                ->first();

            if ($student) {
                
                $unpaidFees = StudentFee::with('feeHead')
                    ->where('student_id', $student->id)
                    ->where('status', 'unpaid')
                    ->get();

                $paidFeesQuery = StudentFee::with(['feeHead', 'collector'])
                    ->where('student_id', $student->id)
                    ->where('status', 'paid')
                    ->latest('updated_at')
                    ->get();

                $paidFeesGroups = $paidFeesQuery->groupBy(function($item) {
                    return $item->receipt_no ? $item->receipt_no : 'single_'.$item->id;
                })->take(10);
            } else {
                return back()->with([
                    'success' => 'এই স্টুডেন্ট আইডিটি পাওয়া যায়নি!',
                    'type' => 'error'
                ]);
            }
        }

        return view('school.fee-manage.payment.index', compact('student', 'unpaidFees', 'paidFeesGroups'));
    }



    public function collectMultiple(Request $request, $tenant)
    {
        try {
            $user = auth()->user();
            
            $request->validate([
                'fee_ids' => 'required|array',
                'fee_ids.*' => 'exists:student_fees,id',
                'payment_method' => 'required|string',
                'discount_type' => 'nullable|in:percent,fixed',
                'discount_value' => 'nullable|numeric|min:0',
                'discount_note' => 'nullable|string|max:255'
            ]);

            $fees = StudentFee::whereIn('id', $request->fee_ids)
                            ->where('school_id', $user->school_id)
                            ->where('status', 'unpaid')
                            ->get();

            if($fees->isEmpty()){
                return back()->with(['success' => 'কোনো ফি সিলেক্ট করা হয়নি বা ইতোমধ্যে পরিশোধিত!', 'type' => 'error']);
            }

            $grossTotal = $fees->sum('amount');
            $discountType = $request->discount_type ?? 'percent';
            $discountValue = floatval($request->discount_value ?? 0);
            $discountNote = $request->discount_note;

            $totalDiscount = 0;
            $discountPercent = 0;
            if ($discountValue > 0 && $grossTotal > 0) {
                if ($discountType === 'percent') {
                    $discountPercent = min(100, $discountValue);
                    $totalDiscount = round(($grossTotal * $discountPercent) / 100, 2);
                } else {
                    $totalDiscount = min($grossTotal, round($discountValue, 2));
                    $discountPercent = round(($totalDiscount / $grossTotal) * 100, 2);
                }
            }

            $receiptNo = 'R' . date('md') . '-' . strtoupper(substr(uniqid(), -4));
            $runningDiscountDistributed = 0;
            $count = $fees->count();
            $index = 0;

            foreach($fees as $fee) {
                $index++;
                $origAmt = ($fee->original_amount && $fee->original_amount > 0) ? $fee->original_amount : $fee->amount;
                $feeDiscount = 0;

                if ($totalDiscount > 0) {
                    if ($index === $count) {
                        // Ensure exact rounding total for last element
                        $feeDiscount = round($totalDiscount - $runningDiscountDistributed, 2);
                    } else {
                        $feeDiscount = round(($fee->amount / $grossTotal) * $totalDiscount, 2);
                        $runningDiscountDistributed += $feeDiscount;
                    }
                }

                $totalItemDiscount = ($fee->discount_amount ?? 0) + $feeDiscount;
                $finalPaid = max(0, round($fee->amount - $feeDiscount, 2));

                $fee->update([
                    'status' => 'paid',
                    'original_amount' => $origAmt,
                    'discount_amount' => $totalItemDiscount,
                    'discount_percent' => $discountPercent > 0 ? $discountPercent : ($fee->discount_percent ?? 0),
                    'paid_amount' => $finalPaid,
                    'amount' => $finalPaid, // Collected amount ensures no residual dues
                    'payment_method' => $request->payment_method,
                    'collected_by' => $user->id,
                    'receipt_no' => $receiptNo,
                    'discount_note' => $discountNote,
                    'updated_at' => now()
                ]);
            }

            $successMessage = 'টাকা সফলভাবে জমা নেওয়া হয়েছে!';
            if ($totalDiscount > 0) {
                $successMessage .= ' (ছাড়: ৳ ' . number_format($totalDiscount, 2) . ')';
            }

            return back()->with([
                'success' => $successMessage,
                'type' => 'success',
                'print_receipt_url' => route('payment.receiptMultiple', ['tenant' => $tenant, 'receipt_no' => $receiptNo])
            ]);
            
        } catch (\Exception $e) {
            return back()->with([
                'success' => 'কিছু একটা সমস্যা হয়েছে: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function collect(Request $request, $tenant, $id)
    {
        try {
            $user = auth()->user();
            
            $fee = StudentFee::where('id', $id)
                            ->where('school_id', $user->school_id)
                            ->firstOrFail();

            $receiptNo = 'R' . date('md') . '-' . strtoupper(substr(uniqid(), -4));

            $discountType = $request->discount_type ?? 'percent';
            $discountValue = floatval($request->discount_value ?? 0);
            $discountNote = $request->discount_note;

            $discountAmt = 0;
            $discountPercent = 0;
            if ($discountValue > 0 && $fee->amount > 0) {
                if ($discountType === 'percent') {
                    $discountPercent = min(100, $discountValue);
                    $discountAmt = round(($fee->amount * $discountPercent) / 100, 2);
                } else {
                    $discountAmt = min($fee->amount, round($discountValue, 2));
                    $discountPercent = round(($discountAmt / $fee->amount) * 100, 2);
                }
            }

            $origAmt = ($fee->original_amount && $fee->original_amount > 0) ? $fee->original_amount : $fee->amount;
            $totalItemDiscount = ($fee->discount_amount ?? 0) + $discountAmt;
            $finalPaid = max(0, round($fee->amount - $discountAmt, 2));

            $fee->update([
                'status' => 'paid',
                'original_amount' => $origAmt,
                'discount_amount' => $totalItemDiscount,
                'discount_percent' => $discountPercent > 0 ? $discountPercent : ($fee->discount_percent ?? 0),
                'paid_amount' => $finalPaid,
                'amount' => $finalPaid,
                'payment_method' => $request->payment_method ?? 'cash',
                'collected_by' => $user->id,
                'receipt_no' => $receiptNo,
                'discount_note' => $discountNote,
                'updated_at' => now()
            ]);

            return back()->with([
                'success' => 'টাকা সফলভাবে জমা নেওয়া হয়েছে (' . ucfirst($request->payment_method ?? 'cash') . ')!',
                'type' => 'success',
                'print_receipt_url' => route('payment.receiptMultiple', ['tenant' => $tenant, 'receipt_no' => $receiptNo])
            ]);
            
        } catch (\Exception $e) {
            return back()->with([
                'success' => 'কিছু একটা সমস্যা হয়েছে: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function downloadReceiptMultiple($tenant, $receiptNo)
    {
        $schoolId = auth()->user()->school_id;
        
        if (str_starts_with($receiptNo, 'single_')) {
            $id = str_replace('single_', '', $receiptNo);
            $fees = StudentFee::with(['student.class', 'feeHead', 'school', 'collector'])->where('id', $id)->where('school_id', $schoolId)->get();
        } else {
            $fees = StudentFee::with(['student.class', 'feeHead', 'school', 'collector'])
                    ->where('receipt_no', $receiptNo)
                    ->where('school_id', $schoolId)
                    ->get();
        }

        if ($fees->isEmpty()) {
            abort(404, 'Receipt not found.');
        }

        $student = $fees->first()->student;
        $school = DB::table('schools')->find($schoolId);
        
        $totalAmount = $fees->sum('amount');
        $subTotal = $fees->sum(function($item) {
            return ($item->original_amount && $item->original_amount > $item->amount) ? $item->original_amount : ($item->amount + ($item->discount_amount ?? 0));
        });
        $totalDiscount = $fees->sum('discount_amount');
        
        $data = [
            'fees' => $fees,
            'school' => $school,
            'student' => $student,
            'receiptNo' => str_starts_with($receiptNo, 'single_') ? ('R' . str_replace('single_', '', $receiptNo)) : $receiptNo,
            'schoolLogo' => $school->logo ?? 'no-logo.png',
            'subTotal' => $subTotal,
            'totalDiscount' => $totalDiscount,
            'totalAmount' => $totalAmount,
            'amountInWords' => $this->amountInWords($totalAmount),
        ];
        $data['software'] = "Educorexa";
        $data['softwareVersion'] = "1.0.0"; 

        $pdf = Pdf::loadView('school.fee-manage.payment.receipt_pdf', $data)->setOptions([
            'isRemoteEnabled' => true,
            'dpi' => 72,
            'isFontSubsetting' => true,
            'isHtml5Parser' => true,
            'defaultFont' => 'SolaimanLipi'
        ]);
        return $pdf->download('receipt-'.$data['receiptNo'].'.pdf');
    }

    public function downloadReceipt($tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $fee = StudentFee::with(['student.class', 'feeHead', 'school', 'collector'])->findOrFail($id);
        $school = DB::table('schools')->find($schoolId);
        
        $subTotal = ($fee->original_amount && $fee->original_amount > $fee->amount) ? $fee->original_amount : ($fee->amount + ($fee->discount_amount ?? 0));
        $totalDiscount = $fee->discount_amount ?? 0;

        $data = [
            'fees' => collect([$fee]),
            'school' => $school,
            'student' => $fee->student,
            'receiptNo' => $fee->receipt_no ?? ('R' . $fee->id),
            'schoolLogo' => $school->logo ?? 'no-logo.png',
            'subTotal' => $subTotal,
            'totalDiscount' => $totalDiscount,
            'totalAmount' => $fee->amount,
            'amountInWords' => $this->amountInWords($fee->amount),
        ];
        $data['software'] = "Educorexa";
        $data['softwareVersion'] = "1.0.0"; 

        $pdf = Pdf::loadView('school.fee-manage.payment.receipt_pdf', $data)->setOptions([
            'isRemoteEnabled' => true,
            'dpi' => 72,
            'isFontSubsetting' => true,
            'isHtml5Parser' => true,
            'defaultFont' => 'SolaimanLipi'
        ]);
        return $pdf->download('receipt-'.$data['receiptNo'].'.pdf');
    }

    private function amountInWords($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty',
            30 => 'thirty', 40 => 'forty', 50 => 'fifty',
            60 => 'sixty', 70 => 'seventy',
            80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Taka ' : '') . $paise;
    }
}