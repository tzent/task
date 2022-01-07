<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\Interfaces\UserHandlerInterface;
use App\Models\Enums\UserStatus;
use App\Models\User;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserHandler extends AbstractHandler implements UserHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     * @param string $phone
     * @return User|null
     */
    public function edit(int $id, string $phone): ?User
    {
        $user = $this->getUser($id);
        if ($user) {
            $details = $user->details()->first();
            if ($details) {
                $details->phone_number = $phone;
                if (false === $user->details()->save($details)) {
                    $this->addError('details', 'User details for user with id '.$id.' were not saved.');
                }
            } else {
                $this->addError('details', 'User details for user with id '.$id.' don\'t exist.');
            }
        }

        return $user;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $user = $this->getUser($id);
        if ($user) {
            if ($user->details()->first() === null) {
                if ($user->delete()) {
                    return true;
                } else {
                    $this->addError('id', 'User with id ' . $id . ' was not deleted.');
                }
            } else{
                $this->addError('details', 'User details for user with id '.$id.' still exist.');
            }
        }

        return false;
    }

    /**
     * @param string $iso2
     * @return Collection
     */
    public function getActiveUsersByCountryIso2(string $iso2): Collection
    {
        return $this->userRepository->findActiveUsersByCountryIso2($iso2);
    }

    /**
     * @param int $id
     * @return User|null
     */
    private function getUser(int $id): ?User
    {
        $user = $this->userRepository->find($id);

        if (null === $user) {
            $this->addError('id', 'User with id '.$id.' not found.');

            return null;
        }

        return $user;
    }
}
