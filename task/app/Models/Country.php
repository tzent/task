<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    protected $fillable = [
        'name',
        'iso2',
        'iso3',
    ];

    public $timestamps = false;

    /**
     * @return HasManyThrough
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(
            related: User::class,
            through: UserDetails::class,
            firstKey: 'citizenship_country_id',
            secondKey: 'id',
            secondLocalKey: 'user_id'
        );
    }

    /**
     * @return HasMany
     */
    public function user_details(): HasMany
    {
        return $this->hasMany(
            related: UserDetails::class,
            foreignKey: 'citizenship_country_id'
        );
    }
}
