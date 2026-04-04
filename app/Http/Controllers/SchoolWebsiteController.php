<?php

namespace App\Http\Controllers;
use App\Models\Notice;
use App\Models\User;
use App\Models\AboutSection;
use App\Models\School;
use App\Models\Slider;
use App\Models\SchoolOverview;
use App\Models\Teacher;
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
        $about = AboutSection::where('school_id', $school->id)->first();

        $teachers = Teacher::where('school_id', $school->id)->orderBy('created_at','asc')->get();

        $admin = User::where('school_id', $school->id)->where('role', 'school_admin')->first();

        if ($admin) {
            // অ্যাডমিনকে টিচার অবজেক্টের মতো করে তৈরি করা
            $adminData = (object)[
                'name' => $admin->name,
                'designation' => 'Principal',
                'subject' => 'Administration',
                'photo' => $admin->photo, 
                'facebook' => $admin->facebook,
                'twitter' => $admin->twitter,
                'linkedin' => $admin->linkedin,
                'insta' => $admin->insta,
            ];
            $teachers->prepend($adminData);
        }

        $overviews = SchoolOverview::where('school_id', $school->id) 
                            ->orderBy('order_by', 'asc')
                            ->get();
        
        return view('school.website.home', compact('school', 'notices', 'sliders', 'about', 'teachers', 'overviews'));
    }

    public function about($tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        return view('school.website.about-us', compact('school'));
    }

    public function resultForm()
    {
        $school = app('currentSchool'); 
        return view('school.website.result', compact('school'));
    }
}
