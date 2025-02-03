<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'action_type',
        'module',
        'action_details',
        'ip_address'
    ];

    protected $casts = [
        'action_details' => 'json'
    ];

    // İlişkiler
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Yardımcı metodlar
    public function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function scopeActionType($query, $type)
    {
        return $query->where('action_type', $type);
    }

    public function scopeByAdmin($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
    }
} 