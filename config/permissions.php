<?php

return [
    'permissions' => [

        'Academic' => [
            'academic-year.manage'  => 'Manage Academic Years',
            'category.manage'       => 'Manage School Categories',
            'sub-category.manage'   => 'Manage School Sub Categories',
            'class.manage'          => 'Manage Classes',
            'section.manage'        => 'Manage Sections',
            'subject.manage'        => 'Manage Subjects',
            'assign.subject'        => 'Assign Subject to Class',
            'class.routine'         => 'Manage Class Routine',
            'syllabus.manage'       => 'Manage Syllabus',
        ],

        'Students & Admissions' => [
            'admission.manage'      => 'Manage Admissions',
            'student.manage'        => 'Manage Students',
            'student.idcard'        => 'Generate Student ID',
            'student.promotion'     => 'Handle Student Promotion',
        ],

        'Staff & HR' => [
            'teacher.manage'        => 'Manage Teachers',
            'assign.teacher'        => 'Assign Teacher to Class',
            'employee.manage'       => 'Manage Staff/Employees',
            'designation.manage'    => 'Manage Designations',
            'payroll.manage'        => 'Manage Payroll',
            'leave.manage'          => 'Manage Leaves',
        ],

        'Attendance & Exams' => [
            'attendance.manage'     => 'Manage Attendance',
            'attendance.report'     => 'View Attendance Reports',
            'holiday.manage'        => 'Setup Holidays',
            'exam.manage'           => 'Manage Exams',
            'mark.manage'           => 'Manage Marks/Results',
            'exam.admit_card'       => 'Generate Admit Cards',
        ],

        'Finance (Fees)' => [
            'fee.manage'            => 'Manage Fee Structure',
            'fee.collect'           => 'Collect Student Fees',
            'fee.report'            => 'View Fee Reports',
        ],

        'Website & Communication' => [
            'notice.manage'         => 'Manage Notices',
            'slider.manage'         => 'Manage Homepage Sliders',
            'gallery.manage'        => 'Manage Photo Gallery',
            'message.manage'        => 'Manage Contact Messages',
            'sms.send'              => 'Send SMS Alerts',
            'email.send'            => 'Send Email Notifications',
        ],

        'SaaS Management (Super Admin/Employee Only)' => [
            'school.manage'         => 'View & Manage All Schools',
            'school.create'         => 'Create New School Instance',
            'school.approve'        => 'Approve/Reject Schools', // এটি আপনার রাউট অনুযায়ী নতুন যোগ করা হয়েছে
            'school.delete'         => 'Delete School Data',
            'settings.manage'       => 'Manage Central System Settings',
            'super.roles.manage'    => 'Manage Roles & Permissions',
        ],
    ],
];