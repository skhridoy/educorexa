<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int $fee_head_id
 * @property int $class_id
 * @property int|null $school_category_id
 * @property int|null $school_sub_category_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SchoolCategory|null $category
 * @property-read \App\Models\Classes|null $class
 * @property-read \App\Models\FeeHead|null $feeHead
 * @property-read \App\Models\SchoolSubCategory|null $subCategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereFeeHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereSchoolCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereSchoolSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeAmount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeeAmount extends Model
{
    protected $fillable = [
        'school_id', 
        'fee_head_id', 
        'class_id', 
        'amount', 
        'school_category_id',
        'school_sub_category_id'
        ];

    public function feeHead() {
        return $this->belongsTo(FeeHead::class);
    }

    public function class() {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // In FeeAmount Model
    public function category() {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }
    public function subCategory() {
        return $this->belongsTo(SchoolSubCategory::class, 'school_sub_category_id');
    }
}