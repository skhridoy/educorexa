<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentTemplateExport implements WithHeadings, ShouldAutoSize
{
    /**
    * ইমপোর্ট করার জন্য প্রয়োজনীয় কলাম হেডিংস
    */
    public function headings(): array
    {
        return [
            'name', 
            'class', 
            'section', 
            'fathers_name', 
            'mothers_name', 
            'contact_number', 
            'date_of_birth', 
            'gender', 
            'religion', 
            'blood_group', 
            'address', 
            'admission_date', 
            'previous_school', 
            'password'
        ];
    }
}