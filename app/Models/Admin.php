<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'boolean',
        'last_login_at' => 'datetime'
    ];

    // İlişkiler
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_roles')
            ->using(AdminRole::class);
    }

    public function logs()
    {
        return $this->hasMany(AdminLog::class);
    }

    // Yardımcı metodlar
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    public function hasPermission($permission)
    {
        return $this->roles->flatMap->permissions->contains('code', $permission);
    }

    public function hasAnyRole($roles)
    {
        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    public function hasAllRoles($roles)
    {
        return $this->roles->whereIn('name', $roles)->count() === count($roles);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('Süper Admin');
    }
} 