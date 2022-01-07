<?php

declare(strict_types=1);

namespace App\Handler\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserHandlerInterface
{
    /**
     * @param int $id
     * @param string $phone
     * @return User|null
     */
    public function edit(int $id, string $phone): ?User;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param string $iso2
     * @return Collection
     */
    public function getActiveUsersByCountryIso2(string $iso2): Collection;
}
