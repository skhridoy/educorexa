<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $logo
 * @property string|null $favicon
 * @property string $slug
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $ein_number
 * @property string|null $emis_code
 * @property string|null $address
 * @property string $status
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AcademicYear> $academicYears
 * @property-read int|null $academic_years_count
 * @property-read User|null $admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admission> $admissions
 * @property-read int|null $admissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Classes> $classes
 * @property-read int|null $classes_count
 * @property-read \App\Models\FooterSetting|null $footerSetting
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $student
 * @property-read int|null $student_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $teacher
 * @property-read int|null $teacher_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereEinNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereEmisCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereFavicon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_active',
        'email',
        'phone',
        'favicon',
        'logo'
    ];

    // ✅ Relation: school has many students
    public function student()
    {
        return $this->hasMany(User::class)
                    ->where('role', 'student');
    }

    // Relation: school has many teachers
    public function teacher()
    {
        return $this->hasMany(User::class)
                    ->where('role', 'teacher');
    }

    // Relation: school has many admins (optional)
    public function admin()
    {
        // এটি নিশ্চিত করবে যে আপনি একটি মাত্র অবজেক্ট পাচ্ছেন, কালেকশন নয়
        return $this->hasOne(User::class, 'school_id')->where('role', 'school_admin');
    }

    // 🔹 School has many Classes
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    // 🔹 School has many Academic Years
    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }

    // 🔹 School has many Admissions
    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    // 🔹 School has many Students
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // 🔹 School has many Users (admin, teacher, student)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function footerSetting()
    {
        return $this->hasOne(FooterSetting::class, 'school_id');
    }
}
