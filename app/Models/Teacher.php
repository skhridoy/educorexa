<?php

namespace App\Models;
use App\Models\TeacherAssignSubject;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string $teacher_id
 * @property string $name
 * @property int $subject_id
 * @property string|null $designation
 * @property string|null $father_name
 * @property string|null $mother_name
 * @property string|null $nid
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $blood_group
 * @property string|null $joining_date
 * @property string|null $qualification
 * @property string|null $photo
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $linkedin
 * @property string|null $insta
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, TeacherAssignSubject> $assignedSubjects
 * @property-read int|null $assigned_subjects_count
 * @property-read \App\Models\School $school
 * @property-read \App\Models\Subject $subject
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereBloodGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereInsta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereJoiningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereMotherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereQualification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Teacher extends Model
{
    protected $fillable = [
        'school_id',
        'teacher_id',
        'name',
        'subject_id',
        'father_name',
        'mother_name',
        'nid',
        'date_of_birth',
        'gender',
        'email',
        'phone',
        'blood_group',
        'joining_date',
        'qualification',
        'photo',
        'address',
        'school_id',
        'facebook',   
        'twitter',   
        'linkedin', 
        'insta',
        'designation'
    ];

    // Relationships, Accessors, Mutators can be added here

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'school_id', 'school_id')
                    ->where('role', 'teacher')
                    ->where('name', $this->name); // Assuming contact_number is used as email for simplicity
    }
    public function assignedSubjects()
    {
        return $this->hasMany(TeacherAssignSubject::class);
    }

}
