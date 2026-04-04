<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFee;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $student = null;
        $unpaidFees = [];
        $paidFees = []; 
        if ($request->filled('student_id')) {
            $student = Student::where('school_id', $schoolId)
                ->where('student_id', $request->student_id)
                ->first();

            if ($student) {
                
                $unpaidFees = StudentFee::with('feeHead')
                    ->where('student_id', $student->id)
                    ->where('status', 'unpaid')
                    ->get();

                $paidFees = StudentFee::with(['feeHead', 'collector']) // এখানে 'teacher' যোগ করুন
                    ->where('student_id', $student->id)
                    ->where('status', 'paid')
                    ->latest()
                    ->limit(5)
                    ->get();
            } else {
                return back()->with([
                    'success' => 'এই স্টুডেন্ট আইডিটি পাওয়া যায়নি!',
                    'type' => 'error'
                ]);
            }
        }

        return view('school.fee-manage.payment.index', compact('student', 'unpaidFees', 'paidFees'));
    }



    public function collect(Request $request, $tenant, $id)
    {
        try {
            $user = auth()->user();
            
            // ১. ফি রেকর্ডটি খুঁজে বের করা
            $fee = StudentFee::where('id', $id)
                            ->where('school_id', $user->school_id)
                            ->firstOrFail();

            // ২. ভেরিয়েবলটি আগে থেকেই নাল (null) হিসেবে ডিফাইন করে রাখুন
            $teacherId = null;

            // ৩. টিচার আইডি খোঁজা
            $teacher = Teacher::where('email', $user->email)->first();
            if ($teacher) {
                $teacherId = $teacher->id;
            }

            // ৪. ডাটা আপডেট করা
            $fee->update([
                'status' => 'paid',
                'payment_method' => $request->payment_method ?? 'cash',
                'collected_by' => $teacherId, // টিচার না হলে নাল যাবে
                'updated_at' => now()
            ]);

            return back()->with([
                'success' => 'টাকা সফলভাবে জমা নেওয়া হয়েছে (' . ucfirst($request->payment_method ?? 'cash') . ')!',
                'type' => 'success'
            ]);
            
        } catch (\Exception $e) {
            return back()->with([
                // এরর মেসেজ দেখার জন্য $e->getMessage() রাখা হয়েছে
                'success' => 'কিছু একটা সমস্যা হয়েছে: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function downloadReceipt($tenant, $id)
    {
        $fee = StudentFee::with(['student.class', 'feeHead', 'school'])->findOrFail($id);

        $data = [
            'fee' => $fee,
            'school' => $fee->school,
            'student' => $fee->student,
            'amountInWords' => $this->amountInWords($fee->amount), // এখানে কল করুন
        ];

        $pdf = Pdf::loadView('school.fee-manage.payment.receipt_pdf', $data);
        return $pdf->download('receipt-'.$fee->id.'.pdf');
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