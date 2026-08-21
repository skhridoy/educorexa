<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\AboutSection;
use App\Models\Classes;
use App\Models\ContactMessage;
use App\Models\Exam;
use App\Models\Notice;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\SchoolOverview;
use App\Models\Slider;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolWebsiteController extends Controller
{
    public function home($tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();

        $notices = Notice::where('school_id', $school->id)
                        ->where('is_active', true)
                        ->orderBy('notice_date', 'desc')
                        ->take(5)
                        ->get();

        $sliders = Slider::where('school_id', $school->id)
                        ->where('status', 1)
                        ->orderBy('order_by', 'asc')
                        ->get();

        $about    = AboutSection::where('school_id', $school->id)->first();
        $teachers = Teacher::where('school_id', $school->id)->orderBy('created_at', 'asc')->get();
        $admin    = User::where('school_id', $school->id)->where('role', 'school_admin')->first();

        if ($admin) {
            $adminData = (object)[
                'name'        => $admin->name,
                'designation' => 'Principal',
                'subject'     => 'Administration',
                'photo'       => $admin->photo,
                'facebook'    => $admin->facebook,
                'twitter'     => $admin->twitter,
                'linkedin'    => $admin->linkedin,
                'insta'       => $admin->insta,
            ];
            $teachers->prepend($adminData);
        }

        $studentCount = Student::where('school_id', $school->id)->count();
        $teacherCount = Teacher::where('school_id', $school->id)->count();

        $overviews = SchoolOverview::where('school_id', $school->id)
                            ->orderBy('order_by', 'asc')
                            ->get();

        return view('school.website.home', compact(
            'school', 'notices', 'sliders', 'about',
            'teachers', 'studentCount', 'teacherCount', 'overviews'
        ));
    }

    public function about($tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        return view('school.website.about-us', compact('school'));
    }

    /**
     * Public Result Page — passes categories & academic years to the view.
     * Exams are loaded dynamically via AJAX (examsByCategory).
     */
    public function resultPage($tenant)
    {
        $school        = School::where('slug', $tenant)->firstOrFail();
        $academicYears = AcademicYear::where('school_id', $school->id)->orderBy('name', 'desc')->get();
        $categories    = SchoolCategory::where('school_id', $school->id)->orderBy('name')->get();

        return view('school.website.result', compact('school', 'academicYears', 'categories'));
    }

    /**
     * AJAX: Return published exams filtered by school_category_id and optional academic_year_id.
     * Used on the public result page for dynamic exam dropdown loading.
     */
    public function examsByCategory(Request $request, $tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();

        $query = Exam::where('school_id', $school->id)->where('is_published', 1);

        if ($request->filled('category_id')) {
            $query->where('school_category_id', $request->category_id);
        }

        if ($request->filled('academic_year_id')) {
            $query->where('year_id', $request->academic_year_id);
        }

        $exams = $query->orderBy('name')->get(['id', 'name']);

        return response()->json(['status' => true, 'exams' => $exams]);
    }

    /**
     * AJAX: Return classes filtered by school_category_id.
     * Used on the public result page for dynamic class dropdown loading.
     */
    public function classesByCategory(Request $request, $tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();

        $query = Classes::where('school_id', $school->id);

        if ($request->filled('category_id')) {
            $query->where('school_category_id', $request->category_id);
        }

        $classes = $query->orderBy('name')->get(['id', 'name']);

        return response()->json(['status' => true, 'classes' => $classes]);
    }

    public function storeMessage($tenant, Request $request)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
        if (!$school) {
            return response()->json(['status' => false, 'message' => 'School not found.'], 404);
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'required',
            'message' => 'required',
        ]);

        ContactMessage::create([
            'school_id' => $school->id,
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'message'   => $request->message,
        ]);

        return back()->with('success', 'আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে!');
    }
}
