<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int|null $school_category_id
 * @property int|null $school_sub_category_id
 * @property int $student_id
 * @property int $fee_head_id
 * @property numeric $amount
 * @property string $month
 * @property string $status
 * @property string|null $payment_method
 * @property int|null $collected_by
 * @property string|null $due_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $fee_type_limit
 * @property-read \App\Models\Classes|null $class
 * @property-read \App\Models\Teacher|null $collector
 * @property-read \App\Models\FeeHead|null $feeHead
 * @property-read mixed $collector_name
 * @property-read \App\Models\School|null $school
 * @property-read \App\Models\Section|null $section
 * @property-read \App\Models\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereCollectedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereFeeHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereFeeTypeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereSchoolCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereSchoolSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentFee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudentFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'school_category_id',
        'school_sub_category_id',
        'fee_head_id',
        'amount',
        'month',
        'status',
        'collected_by',
        'payment_method',
        'due_date',
        'receipt_no'
    ];

    /**
     * যে স্টুডেন্টের এই ফি।
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * এই ফি-টি কোন হেডের (যেমন: মাসিক বেতন বা ভর্তি ফি)।
     */
    public function feeHead()
    {
        return $this->belongsTo(FeeHead::class);
    }

    /**
     * কোন স্কুলের আন্ডারে এই ফি।
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * পেমেন্ট স্ট্যাটাস চেক করার জন্য হেল্পার মেথড (অপশনাল)
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isUnpaid()
    {
        return $this->status === 'unpaid';
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }

    public function getCollectorNameAttribute()
    {
        return $this->collector ? $this->collector->name : 'Admin';
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
                    
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
                    
    }
}