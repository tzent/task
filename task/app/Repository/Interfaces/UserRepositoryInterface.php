<?php

declare(strict_types=1);

namespace App\Repository\Interfaces;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * @param string $iso2
     * @return Collection
     */
    public function findActiveUsersByCountryIso2(string $iso2): Collection;
}
