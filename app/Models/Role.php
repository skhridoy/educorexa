<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'display_name',
        'guard_name',
        'school_id',
        'role_type',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
