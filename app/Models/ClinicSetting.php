<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicSetting extends Model
{
    protected $table = 'clinic_settings';

    protected $fillable = ['key', 'value', 'label'];

    /**
     * Ambil nilai setting berdasarkan key.
     * Contoh: ClinicSetting::get('clinic_address')
     */
    public static function getValue(string $key, string $default = ''): string
    {
        $row = static::where('key', $key)->first();
        return $row?->value ?? $default;
    }

    /**
     * Simpan banyak setting sekaligus.
     * Contoh: ClinicSetting::setMany(['clinic_name' => 'X', 'clinic_address' => 'Y'])
     */
    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            static::where('key', $key)->update(['value' => $value]);
        }
    }

    /**
     * Ambil semua setting sebagai array ['key' => 'value']
     */
    public static function allAsArray(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }
}
