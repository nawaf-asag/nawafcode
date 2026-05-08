<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'value_en'];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (! $setting) return $default;

        $locale = app()->getLocale();
        if ($locale === 'en' && filled($setting->value_en)) {
            return $setting->value_en;
        }
        return $setting->value;
    }

    public static function set(string $key, $value, ?string $valueEn = null): void
    {
        $payload = ['value' => $value];
        if ($valueEn !== null) {
            $payload['value_en'] = $valueEn;
        }
        static::updateOrCreate(['key' => $key], $payload);
    }

    /**
     * Returns key => localized value pairs for all settings,
     * automatically picking value_en when locale is "en" (with AR fallback).
     */
    public static function localizedAll(): \Illuminate\Support\Collection
    {
        $locale = app()->getLocale();
        return static::all()->mapWithKeys(function ($s) use ($locale) {
            $value = ($locale === 'en' && filled($s->value_en)) ? $s->value_en : $s->value;
            return [$s->key => $value];
        });
    }
}
