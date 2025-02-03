<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'module'
    ];

    // İlişkiler
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
            ->using(RolePermission::class);
    }

    // Yardımcı metodlar
    public function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function scopeCode($query, $code)
    {
        return $query->where('code', $code);
    }
} 