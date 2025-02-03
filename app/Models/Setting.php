<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group'
    ];

    protected $casts = [
        'value' => 'json'
    ];

    /**
     * Belirtilen ayarı getir
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        if ($setting->type === 'boolean') {
            return filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
        }

        if ($setting->type === 'integer') {
            return (int) $setting->value;
        }

        if ($setting->type === 'float') {
            return (float) $setting->value;
        }

        if ($setting->type === 'array' || $setting->type === 'json') {
            return json_decode($setting->value, true);
        }

        return $setting->value;
    }

    /**
     * Ayar değerini güncelle veya oluştur
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string $group
     * @return void
     */
    public static function set($key, $value, $type = 'string', $group = 'general')
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group
            ]
        );
    }

    /**
     * Belirli bir gruptaki tüm ayarları getir
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public static function getGroup($group)
    {
        return static::where('group', $group)->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->value];
            });
    }

    public function scopeGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
} 