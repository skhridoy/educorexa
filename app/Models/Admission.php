<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int $academic_year_id
 * @property int $class_id
 * @property string $admission_number
 * @property string $name
 * @property string|null $email
 * @property string|null $previous_school
 * @property string|null $previous_class
 * @property string $fathers_name
 * @property string $mothers_name
 * @property string|null $father_nid
 * @property string|null $mother_nid
 * @property string|null $student_birth_nid
 * @property string $contact_number
 * @property string|null $password
 * @property string|null $photo
 * @property string $status
 * @property string|null $admin_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AcademicYear $academicYear
 * @property-read \App\Models\Classes $class
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereAdminNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereAdmissionNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereFatherNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereFathersName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereMotherNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereMothersName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission wherePreviousClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission wherePreviousSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereStudentBirthNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admission extends Model
{
    protected $fillable = [
    'school_id',
    'academic_year_id',
    'class_id',
    'admission_number',
    'name',
    'email',
    'previous_school',
    'previous_class',
    'fathers_name',
    'mothers_name',
    'father_nid',
    'mother_nid',
    'student_birth_nid',
    'contact_number',
    'password',
    'photo',
    'status',
    'admin_note',
];

    // 🔹 Admission belongs to School
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // 🔹 Admission belongs to Academic Year
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // 🔹 Admission belongs to Class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }


}
