<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\FeeHead;
use App\Models\FeeAmount;
use App\Models\SchoolCategory;
use App\Models\SchoolSubCategory;
use Illuminate\Http\Request;

class FeeAmountController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        
        $feeHeads = FeeHead::where('school_id', $schoolId)->get();
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        
        $feeAmounts = FeeAmount::with(['feeHead', 'class', 'category', 'subCategory'])
            ->where('school_id', $schoolId)
            ->latest()
            ->paginate(5);

        return view('school.fee-manage.fee-amount.index', compact('feeHeads', 'categories', 'feeAmounts'));
    }

public function getClassesByCategory(Request $request) {
    $schoolId = auth()->user()->school_id;
    $categoryId = $request->category_id;
    $feeHeadId = $request->fee_head_id;
    $subCategoryId = $request->sub_category_id;

    // ১. ওই ক্যাটেগরির ক্লাসগুলো নিন
    $classes = Classes::where('school_id', $schoolId)
                    ->where('school_category_id', $categoryId)
                    ->get();

    $existingAmounts = [];
    if ($feeHeadId) {
        $query = FeeAmount::where('school_id', $schoolId)
            ->where('fee_head_id', $feeHeadId)
            ->where('school_category_id', $categoryId);

        // ২. সাব-ক্যাটেগরি লজিক ফিক্স
        if ($subCategoryId && $subCategoryId !== 'null' && $subCategoryId !== '') {
            $query->where('school_sub_category_id', $subCategoryId);
        } else {
            $query->whereNull('school_sub_category_id');
        }

        $existingAmounts = $query->pluck('amount', 'class_id');
    }
                    
    return response()->json([
        'classes' => $classes,
        'existingAmounts' => $existingAmounts
    ]);
}

    public function getSubCategories($tenant, $categoryId)
    {
        $subCategories = SchoolSubCategory::where('school_category_id', $categoryId)
                            ->where('school_id', auth()->user()->school_id)
                            ->get();

        return response()->json($subCategories);
    }

    public function store(Request $request) {
        $request->validate([
            'fee_head_id' => 'required',
            'school_category_id' => 'required',
            'amounts' => 'required|array'
        ]);

        $schoolId = auth()->user()->school_id;

        foreach ($request->amounts as $classId => $amount) {
            if ($amount !== null && $amount !== '') {
                FeeAmount::updateOrCreate(
                    [
                        'school_id'              => $schoolId,
                        'fee_head_id'            => $request->fee_head_id,
                        'class_id'               => $classId,
                        'school_category_id'     => $request->school_category_id,
                        'school_sub_category_id' => $request->school_sub_category_id ?? null,
                    ],
                    ['amount' => $amount]
                );
            }
        }

        return back()->with('success', 'Fee structure updated successfully!');
    }

    /**
     * Edit - একক কোনো ফি রেকর্ড এডিট করার জন্য (যদি মডাল বা আলাদা পেজ লাগে)
     */
    public function edit($tenant, $id)
    {
        $feeAmount = FeeAmount::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $feeHeads = FeeHead::where('school_id', auth()->user()->school_id)->get();
        $categories = SchoolCategory::where('school_id', auth()->user()->school_id)->get();
        
        // এডিট পেজ যদি আলাদা হয় তবে এটি ব্যবহার করবেন
        return view('school.fee-manage.fee-amount.edit', compact('feeAmount', 'feeHeads', 'categories'));
    }

    /**
     * Update - একক রেকর্ড আপডেট
     */
    public function update(Request $request, $tenant, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        $feeAmount = FeeAmount::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $feeAmount->update([
            'amount' => $request->amount
        ]);

        return back()->with('success', 'Fee amount updated successfully!');
    }

    /**
     * Destroy - রেকর্ড ডিলিট
     */
    public function destroy($tenant, $id)
    {
        $feeAmount = FeeAmount::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $feeAmount->delete();

        return back()->with('success', 'Fee record deleted successfully!');
    }
}