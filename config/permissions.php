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
            'lesson.view'           => 'View Lessons',
            'lesson.manage'         => 'Manage Lessons',
            'homework.manage'       => 'Manage Homework',
            'syllabus.view'        => 'View Syllabus',
            'syllabus.download'    => 'Download Syllabus',
            'syllabus.upload'      => 'Upload Syllabus',
            'syllabus.delete'      => 'Delete Syllabus',
            'syllabus.approve'     => 'Approve Syllabus',
            'syllabus.reject'      => 'Reject Syllabus',
            'syllabus.view_rejected' => 'View Rejected Syllabus',
            'syllabus.view_approved' => 'View Approved Syllabus',
        
        ],

        'Students & Admissions' => [
            'admission.manage'      => 'Manage Admissions',
            'student.index'         => 'View Student List',
            'student.create'        => 'Add New Student',
            'student.edit'          => 'Edit Student Info',
            'student.delete'        => 'Delete Student Record',
            'student.manage'        => 'Manage All Student Operations',
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
            'attendance.manage'     => 'Manage Staff Attendance',
            'attendance.report'     => 'View Staff Attendance Reports',
            'payroll.report'        => 'View Payroll Reports',
            'staff.report'          => 'View Staff Reports',
            'staff.idcard'          => 'Generate Staff ID',
            'staff.promotion'       => 'Handle Staff Promotion',
            'staff.transfer'        => 'Handle Staff Transfer',
            'staff.termination'     => 'Handle Staff Termination',
            'staff.leave'           => 'Manage Staff Leaves',
            'staff.attendance'       => 'Manage Staff Attendance',
            'staff.payroll'          => 'Manage Staff Payroll',
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

        'Settings' => [
            'newsletter.manage'      => 'Manage Newsletter Subscribers',
            'system.settings'       => 'Manage System Settings',
            'slider.manage'         => 'Manage Homepage Sliders',
            'gallery.manage'        => 'Manage Photo Gallery',
        ],

        'SaaS Management (Super Admin/Employee Only)' => [
            'school.manage'         => 'View & Manage All Schools',
            'school.create'         => 'Create New School Instance',
            'school.approve'        => 'Approve/Reject Schools', // এটি আপনার রাউট অনুযায়ী নতুন যোগ করা হয়ছে
            'frontend.manage'       => 'Manage Frontend Sections',
            'school.reject'         => 'Reject School Data',
            'school.delete'         => 'Delete School Data',
            'settings.manage'       => 'Manage Central System Settings',
            'super.roles.manage'    => 'Manage Roles & Permissions',
            'contact.messages.view'   => 'View Contact Messages',
            'testimonial.approve'   => 'Approve/Manage Testimonials',
            'support.manage'        => 'Manage School Support Tickets',
            'support.bot.manage'    => 'Manage Help Support Chat Bot',
        ],
    ],
];