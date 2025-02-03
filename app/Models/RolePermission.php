<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends Pivot
{
    use HasFactory;

    protected $table = 'role_permissions';

    public $incrementing = true;

    protected $fillable = [
        'role_id',
        'permission_id'
    ];

    // İlişkiler
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
} 