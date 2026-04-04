<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeAmount extends Model
{
    protected $fillable = ['school_id', 'fee_head_id', 'class_id', 'amount'];

    public function feeHead() {
        return $this->belongsTo(FeeHead::class);
    }

    public function class() {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}