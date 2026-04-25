<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $employee_id
 * @property string|null $designation
 * @property string|null $phone_personal
 * @property string|null $address
 * @property string|null $joining_date
 * @property numeric $salary
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereJoiningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee wherePhonePersonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereUserId($value)
 * @mixin \Eloquent
 */
class Employee extends Model
{
    protected $fillable = [
        'user_id', 'employee_id', 'designation', 
        'phone_personal', 'address', 'joining_date', 
        'salary', 'status'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
}
