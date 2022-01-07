<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class User extends Model
{
    protected $fillable = [
        'email',
        'active',
    ];

    /**
     * @return HasOne
     */
    public function details(): HasOne
    {
        return $this->hasOne(related: UserDetails::class);
    }

    /**
     * @return HasOneThrough
     */
    public function country(): HasOneThrough
    {
        return $this->hasOneThrough(
            related: Country::class,
            through: UserDetails::class,
            secondKey: 'id',
            secondLocalKey: 'citizenship_country_id'
        );
    }
}
