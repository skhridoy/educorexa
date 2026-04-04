<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class StudentsExport implements FromQuery, WithHeadings, WithMapping
{
    
    public function query()
    {
        return Student::query()
            ->where('school_id', Auth::user()->school_id)
            ->with(['class', 'section']); 
    }

    /**
     * এক্সেল ফাইলের হেডিং সেট করা
     */
    public function headings(): array
    {
        return [
            'Student ID',
            'Name',
            'Class',
            'Section',
            'Fathers Name',
            'Mothers Name',
            'Contact Number',
            'Gender',
            'Religion',
            'Blood Group',
            'Date of Birth',
            'Admission Date',
            'Address',
            'Status'
        ];
    }

    /**
     * প্রতিটি রো-তে কোন ডাটা বসবে তা ম্যাপ করা
     */
    public function map($student): array
    {
        return [
            $student->student_id,
            $student->name,
            $student->class->name ?? 'N/A',
            $student->section->name ?? 'N/A',
            $student->fathers_name,
            $student->mothers_name,
            $student->contact_number,
            $student->gender,
            $student->religion,
            $student->blood_group,
            $student->date_of_birth,
            $student->admission_date,
            $student->address,
            $student->status,
        ];
    }
}