<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{


    /**
     * Get the active school ID from user or request context.
     */
    private function getSchoolId(?Request $request = null): ?int
    {
        return auth()->user()?->school_id
            ?? (app()->bound('currentSchool') ? app('currentSchool')->id : null)
            ?? ($request ? $request->school_id : null);
    }

    public function index(Request $request)
    {
        $schoolId = $this->getSchoolId($request);

        $academicYears = AcademicYear::where('school_id', $schoolId)
            ->latest()
            ->paginate(10);

        return view('school.academic-year.index', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $schoolId = $this->getSchoolId($request);

        if (!$schoolId) {
            return back()->withErrors(['school_id' => 'School context could not be identified.']);
        }

        $request->validate([
            'name' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::transaction(function () use ($request, $schoolId) {

            if ($request->is_active) {
                AcademicYear::where('school_id', $schoolId)
                    ->update(['is_active' => false]);
            }

            AcademicYear::create([
                'school_id' => $schoolId,
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->is_active ? true : false,
            ]);
        });

        return back()->with('success', 'Academic Year created successfully.');
    }

    public function update(Request $request, $tenant, $academic_year)
    {
        $schoolId = $this->getSchoolId($request);
        $academicYearId = $academic_year instanceof AcademicYear ? $academic_year->id : $academic_year;

        $academicYear = AcademicYear::where('id', $academicYearId)
            ->where('school_id', $schoolId)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::transaction(function () use ($request, $academicYear, $schoolId) {

            if ($request->is_active) {
                AcademicYear::where('school_id', $schoolId)
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
        $schoolId = $this->getSchoolId(); 
        $academicYear = AcademicYear::where('id', $academic_year)
                                    ->where('school_id', $schoolId)
                                    ->firstOrFail();

        $academicYear->delete();

        $tenantSlug = app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? $tenant);

        return redirect()->route('academic-year.index', ['tenant' => $tenantSlug])
                        ->with('success', 'Academic year deleted successfully.');
    }

    public function toggleActive($tenant, $academic_year)
    {
        $schoolId = $this->getSchoolId();

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
        $schoolId = $this->getSchoolId();

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
