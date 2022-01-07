<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetails extends Model
{
    protected $table = 'user_details';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
    ];

    protected $guarded = [
        'citizenship_country_id'
    ];

    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(related: Country::class, foreignKey: 'citizenship_country_id');
    }
}
