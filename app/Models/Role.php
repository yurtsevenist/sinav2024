<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // İlişkiler
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_roles')
            ->using(AdminRole::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->using(RolePermission::class);
    }

    // Yardımcı metodlar
    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('code', $permission)->firstOrFail();
        }
        
        $this->permissions()->syncWithoutDetaching($permission);
    }

    public function withdrawPermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('code', $permission)->firstOrFail();
        }
        
        $this->permissions()->detach($permission);
    }

    public function updatePermissions($permissions)
    {
        $this->permissions()->sync($permissions);
    }
} 