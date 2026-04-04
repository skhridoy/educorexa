<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{


    public function index()
    {
        $academicYears = AcademicYear::where('school_id', auth()->user()->school_id)
            ->latest()
            ->paginate(10);

        return view('school.academic-year.index', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::transaction(function () use ($request) {

            if ($request->is_active) {
                AcademicYear::where('school_id', auth()->user()->school_id)
                    ->update(['is_active' => false]);
            }

            AcademicYear::create([
                'school_id' => auth()->user()->school_id,
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->is_active ? true : false,
            ]);
        });

        return back()->with('success', 'Academic Year created successfully.');
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        abort_if($academicYear->school_id !== auth()->user()->school_id, 403);

        $request->validate([
            'name' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::transaction(function () use ($request, $academicYear) {

            if ($request->is_active) {
                AcademicYear::where('school_id', auth()->user()->school_id)
                    ->update(['is_active' => false]);
            }

            $academicYear->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->is_active ? true : false,
            ]);
        });

        return back()->with('success', 'Academic Year updated successfully.');
    }

    public function destroy($tenant, $academic_year)
    {
        // Make sure the academic year belongs to the tenant (school)
        $schoolId = auth()->user()->school_id; 
        $academicYear = AcademicYear::where('id', $academic_year)
                                    ->where('school_id', $schoolId)
                                    ->firstOrFail();

        $academicYear->delete();

        return redirect()->route('academic-year.index', ['tenant' => auth()->user()->school->slug])
                        ->with('success', 'Academic year deleted successfully.');
    }

    public function toggleActive($tenant, $academic_year)
    {
        $schoolId = auth()->user()->school_id;

        // Find the selected academic year for this school
        $academicYear = AcademicYear::where('id', $academic_year)
                                    ->where('school_id', $schoolId)
                                    ->firstOrFail();

        // Set all other academic years to inactive for this school
        AcademicYear::where('school_id', $schoolId)
                    ->update(['is_active' => false]);

        // Toggle the selected year to active
        $academicYear->is_active = true;
        $academicYear->save();

        return redirect()->back()->with('success', 'Academic year ' . $academicYear->name . ' activated successfully.');
    }

    public function toggleInactive($tenant, $academic_year)
    {
        $schoolId = auth()->user()->school_id;

        // Find the selected academic year for this school
        $academicYear = AcademicYear::where('id', $academic_year)
                                    ->where('school_id', $schoolId)
                                    ->firstOrFail();

        // Toggle the selected year to inactive
        $academicYear->is_active = false;
        $academicYear->save();

        return redirect()->back()->with('success', 'Academic year ' . $academicYear->name . ' set to inactive successfully.');
    }
}
