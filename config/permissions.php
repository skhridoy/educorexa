<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System Permissions
    |--------------------------------------------------------------------------
    | Key => permission identifier (Database name)
    | Value => Human readable label (Display name)
    |--------------------------------------------------------------------------
    */

    'permissions' => [

        'Academic' => [
            'academic-year.manage' => 'Manage Academic Years',
            'class.manage'         => 'Manage Classes',
            'section.manage'       => 'Manage Sections',
            'subject.manage'       => 'Manage Subjects',
            'assign.subject'       => 'Assign Subject to Class',
            'class.timetable'      => 'Manage Class Timetable',
            'syllabus.manage'      => 'Manage Syllabus',
            'class.routine'       => 'Manage Class Routine',
            'class.routine.view'  => 'View Class Routine',
            'category.manage'       => 'Manage School Categories',
            'sub-category.manage'   => 'Manage School Sub Categories',
        ],

        'Admissions' => [
            'admission.manage'     => 'Manage Admissions',
        ],

        'Teachers' => [
            'teacher.manage'       => 'Manage Teachers',
            'assign.teacher'       => 'Assign Teacher to Class',
        ],

        'Students' => [
            'student.manage'       => 'Manage Students',
            'student.idcard'       => 'Generate Student Id',
            'student.promotion'    => 'Student Promotion',
        ],

        'Subjects & Assign' => [
            'assign.subject'       => 'Assign Subject to Class',
            'subject.manage'       => 'Manage Subjects',

        ],

        'Attendance' => [
            'attendance.manage'    => 'Manage Attendance',
            'attendance.report'    => 'View Attendance Report',
            'attendance.view'      => 'View Attendance',
            'holiday.manage'       => 'Setup Holidays'
        ],

        'Exams' => [
            'exam.manage'          => 'Manage Exams',
            'exam.publish'         => 'Publish Exam Results',
            'exam.admit_card'      => 'Generate Admit Cards',
        ],

        'Marks' => [
            'mark.manage'          => 'Manage Marks',
            'student.promotion'    => 'Student Promotion',
            'mark.view'            => 'View Marks',
        ],

        'Fees' => [
            'fee.manage'           => 'Manage Fee Structure',
            'fee.collect'          => 'Collect Student Fees',
            'fee.report'           => 'View Fee Reports',
            'fee.payment.history'    => 'View Payment History',
        ],

        'Library' => [
            'library.manage'       => 'Manage Library',
        ],

        'Transport' => [
            'transport.manage'     => 'Manage Transport',
            'transport.assign'     => 'Assign Transport to Student',
            'transport.view'       => 'View Transport Details',
        ],

        'Lesson Plans' => [
            'lesson.manage'        => 'Manage Lesson Plans',
            'lesson.create'        => 'Create Lesson Plans',
            'lesson.view'          => 'View Lesson Plans',
            'lesson.download'      => 'Download Lesson Plans',
        ],

        'Sms' => [
            'message.manage'         => 'Manage Messages',
            'sms.manage'           => 'Manage SMS',
            'sms.send'             => 'Send SMS',
        ],

        'Email' => [
            'email.manage'         => 'Manage Emails',
            'email.send'           => 'Send Emails',
        ],

        'Website Content' => [
            'notice.manage'        => 'Manage Notices',
            'newsletter.manage'    => 'Manage Newsletters',
            'system.settings'      => 'Access System Settings',
            'testimonial.manage'    => 'Manage Testimonials',
            'slider.manage'         => 'Manage Sliders',
            'gallery.manage'        => 'Manage Gallery',
            'page.manage'           => 'Manage Pages',
            'contact.manage'        => 'Manage Contact Messages',
            'social.manage'         => 'Manage Social Links',
        ],

        'Staff & HR' => [
            'designation.manage' => 'Manage Designations',
            'school.create' => 'Create School',
            'school.edit' => 'Edit School',
            'school.delete' => 'Delete School',
            'school.view' => 'View School',
            'employee.manage' => 'Manage Employees',
            'employee.index'  => 'View Employees',
            'employee.create' => 'Add Employee',
            'employee.edit'   => 'Edit Employee',
            'employee.delete' => 'Delete Employee',
            'payroll.manage' => 'Manage Payroll',
            'payroll.view'   => 'View Payroll',
            'payroll.create' => 'Create Payroll',
            'payroll.edit'   => 'Edit Payroll',
            'payroll.delete' => 'Delete Payroll',
            'leave.manage'   => 'Manage Leaves',
            'leave.view'     => 'View Leaves',
            'leave.create'   => 'Create Leave',
            'leave.edit'     => 'Edit Leave',
            'leave.delete'   => 'Delete Leave',
            
        ],
        'Super Admin Access' => [
            'school.manage' => 'Manage Schools',
            'super.roles.manage' => 'Manage Roles',
            'super.settings.manage' => 'Manage Settings',
            'performance.manage' => 'Manage Performance',
            'performance.view'   => 'View Performance',
            'performance.create' => 'Create Performance',
            'performance.edit'   => 'Edit Performance',
            'performance.delete' => 'Delete Performance',
        ],
    ],

];