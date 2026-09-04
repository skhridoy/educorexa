<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int $school_id
 * @property int $academic_year_id
 * @property int $class_id
 * @property int|null $school_category_id
 * @property int $section_id
 * @property string $student_id
 * @property int|null $roll
 * @property string $name
 * @property string|null $previous_school
 * @property string|null $previous_class
 * @property string|null $fathers_name
 * @property string|null $mothers_name
 * @property string|null $father_nid
 * @property string|null $mother_nid
 * @property string|null $student_birth_nid
 * @property string|null $contact_number
 * @property string $password
 * @property string|null $photo
 * @property string $status
 * @property int|null $created_by
 * @property string|null $religion
 * @property string|null $gender
 * @property string|null $date_of_birth
 * @property string|null $admission_date
 * @property string|null $blood_group
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $school_sub_category_id
 * @property-read \App\Models\AcademicYear|null $academicYear
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\SchoolCategory|null $category
 * @property-read \App\Models\Classes|null $class
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentFee> $fees
 * @property-read int|null $fees_count
 * @property-read \App\Models\SchoolSubCategory|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Mark> $marks
 * @property-read int|null $marks_count
 * @property-read \App\Models\School|null $school
 * @property-read \App\Models\Section|null $section
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentSession> $sessions
 * @property-read int|null $sessions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentFee> $unpaidFees
 * @property-read int|null $unpaid_fees_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereAdmissionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereBloodGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereFatherNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereFathersName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereMotherNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereMothersName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student wherePreviousClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student wherePreviousSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereReligion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereRoll($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereSchoolCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereSchoolSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStudentBirthNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUserId($value)
 * @mixin \Eloquent
 */
class Student extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'academic_year_id',
        'class_id',
        'school_category_id', // যুক্ত করা হয়েছে
        'section_id',
        'student_id',
        'roll',
        'name',
        'name_bn',           // বাংলা নাম
        'previous_school',
        'previous_school_bn', // বাংলা পূর্ববর্তী স্কুল
        'previous_class',
        'previous_class_bn',  // বাংলা পূর্ববর্তী শ্রেণি
        'fathers_name',
        'fathers_name_bn',    // পিতার বাংলা নাম
        'mothers_name',
        'mothers_name_bn',    // মাতার বাংলা নাম
        'father_nid',
        'mother_nid',
        'student_birth_nid',
        'contact_number',
        'password',
        'photo',
        'status',
        'religion',
        'gender',
        'date_of_birth',
        'admission_date',
        'blood_group',
        'address',
        'address_bn',         // বাংলা ঠিকানা
        'admin_note',
        'created_by',
        'school_sub_category_id',
        'admission_id'
    ];

    /**
     * Generate unique student ID per school starting from STD-[year(2 digit)]1001
     * e.g. STD-261001, STD-261002, etc.
     */
    public static function generateStudentId($schoolId, $academicYear = null): string
    {
        if ($academicYear && !empty($academicYear->name)) {
            $yearPart = substr($academicYear->name, -2);
        } else {
            $yearPart = date('y');
        }
        $prefix = 'STD-' . $yearPart;

        $lastSerial = self::where('school_id', $schoolId)
            ->where('student_id', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, -4) AS UNSIGNED)) as max_serial")
            ->value('max_serial');

        $nextNumber = $lastSerial ? $lastSerial + 1 : 1001;

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    // 🔹 স্টুডেন্ট কোন ক্যাটেগরির (Primary/High School) আন্ডারে
    public function category()
    {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }

    // 🔹 স্টুডেন্ট কোন গ্রুপের (Science/Arts) আন্ডারে - আপনি অলরেডি group() নামে দিয়েছেন
    public function group()
    {
        return $this->belongsTo(SchoolSubCategory::class, 'school_sub_category_id');
    }

    // 🔹 Student belongs to Admission (Reference)
    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

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

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function sessions()
    {
        return $this->hasMany(StudentSession::class);
    }
    
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function fees() {
        return $this->hasMany(StudentFee::class);
    }

    public function unpaidFees() {
        return $this->hasMany(StudentFee::class)->where('status', 'unpaid');
    }

    public function feeConcessions() {
        return $this->hasMany(StudentFeeConcession::class);
    }
}