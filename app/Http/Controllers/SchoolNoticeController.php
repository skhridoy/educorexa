<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class SchoolNoticeController extends Controller
{
    // Show all notices for current school
    public function index()
    {
        $school = app('currentSchool'); // Injected from middleware

        $notices = Notice::where('school_id', $school->id)
                         ->latest()
                         ->paginate(10); // Pagination

        return view('school.website.notices', compact('school', 'notices'));
    }

    // Show single notice
    public function show($id)
    {
        $school = app('currentSchool');

        $notice = Notice::where('school_id', $school->id)
                        ->where('id', $id)
                        ->firstOrFail();

        return view('school.website.notice-show', compact('school', 'notice'));
    }
}

