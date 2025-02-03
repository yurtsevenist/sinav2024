<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminRole extends Pivot
{
    use HasFactory;

    protected $table = 'admin_roles';

    public $incrementing = true;

    protected $fillable = [
        'admin_id',
        'role_id'
    ];

    // İlişkiler
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
} 