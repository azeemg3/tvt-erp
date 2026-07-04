<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * Fallback address used before the company profile has been configured.
     */
    const DEFAULT_ADDRESS = 'UG-9, Big City Plaza, Liberty Round About, Gulberg III, Lahore, PK';

    /**
     * Default logo asset path (relative to the public root, matching how the
     * existing print templates reference images via URL::asset()).
     */
    const DEFAULT_LOGO = 'public/dist/img/company-logo.png';

    protected $table = 'companies';

    protected $guarded = [];

    /**
     * Cached instance of the active company profile for the current request.
     *
     * @var static|null
     */
    protected static $current = null;

    /**
     * Get the active (single) company profile.
     *
     * Falls back to a non-persisted instance carrying the default values so the
     * views/PDF templates keep rendering even before the table is migrated/seeded.
     */
    public static function current(): self
    {
        if (static::$current instanceof self) {
            return static::$current;
        }

        $company = null;

        try {
            $company = static::query()->orderBy('id')->first();
        } catch (\Throwable $e) {
            // Table not migrated yet (e.g. during install/migrate) — use defaults.
            $company = null;
        }

        if (!$company) {
            $company = new static([
                'name' => config('app.name', 'Company'),
                'address' => self::DEFAULT_ADDRESS,
                'phone' => '4298765432',
                'email' => 'sales@uotrips.co',
                'website' => 'www.uotrips.com',
                'govt_lic_no' => '321',
                'iata_no' => '133',
                'ntn' => '85212',
                'powered_by' => 'Al-Hussain Int',
                'contact_no' => '+92 021 35210452 - +92 333 2071887',
                'logo' => self::DEFAULT_LOGO,
            ]);
        }

        return static::$current = $company;
    }

    /**
     * Clear the cached profile (call after updating the company settings).
     */
    public static function flushCurrent(): void
    {
        static::$current = null;
    }

    /**
     * Address with a safe fallback so print/report headers never render blank.
     */
    public function getAddressAttribute($value): string
    {
        return $value !== null && $value !== '' ? $value : self::DEFAULT_ADDRESS;
    }

    /**
     * Fully-qualified URL for the company logo, with a safe fallback so print
     * headers always render an image.
     */
    public function getLogoUrlAttribute(): string
    {
        $path = $this->logo !== null && $this->logo !== '' ? $this->logo : self::DEFAULT_LOGO;

        return asset($path);
    }
}
