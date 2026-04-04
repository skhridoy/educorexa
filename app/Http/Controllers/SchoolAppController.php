<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolAppController extends Controller
{
    public function dashboard()
    {
        $totalStudents = 100; // Example data, replace with actual logic to fetch students
        $totalTeachers = 20; // Example data, replace with actual logic to fetch teachers
        $totalClasses = 10; // Example data, replace with actual logic to fetch classes
        $totalSubjects = 15; // Example data, replace with actual logic to fetch subjects

        return view('school.admin.dashboard', compact('totalStudents', 'totalTeachers', 'totalClasses', 'totalSubjects'));
    }

}
