<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Enums\UserStatus;
use App\Models\User;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return $this->model->find($id);
    }

    /**
     * @param string $iso2
     * @return Collection
     */
    public function findActiveUsersByCountryIso2(string $iso2): Collection
    {
        return
            $this
                ->model
                ->whereHas('country', function(Builder $query) use ($iso2) {
                    $query->where('iso2', $iso2);
                })
                ->where('active', UserStatus::ACTIVE)
                ->get();
    }
}
