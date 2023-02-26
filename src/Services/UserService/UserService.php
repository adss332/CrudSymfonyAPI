<?php

namespace App\Services\UserService;

use App\DTO\UserCreateDTO;
use App\DTO\UserUpdateDTO;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class UserService
 * @package App\Services\UserService
 */
class UserService implements UserServiceInterface
{

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }


    /**
     * @inheritDoc
     */
    public function getUsersByPageAndLimit(int $page, int $limit): array
    {
        $usersArray = $this->userRepository->getUsersByPageAndLimit($page, $limit);

        if (!$usersArray) {
            throw new EntityNotFoundException(_('Список пользователей пуст'));
        }

        return $usersArray;
    }

    /**
     * @inheritDoc
     */
    public function getUserById(int $id): User
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneBy(['id' => $id, 'soft_delete' => false]);
        if ($user === null) {
            throw new EntityNotFoundException(sprintf(_('Пользователь с id:%s не найден.'), $id));
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function createUser(UserCreateDTO $userInfo): int
    {
        if ($userInfo->getParentId()) {
            $isParentExist = $this->getUserById($userInfo->getParentId());
            if ($isParentExist) {
                $this->hasParent($userInfo->getParentId());
            } else {
                throw new \Exception(_('Вы не можете привязать родителя с таким id, он не существует!'));
            }
        }

        $createdUser = new User();
        $createdUser
            ->setFirstName($userInfo->getFirstName())
            ->setLastName($userInfo->getLastName())
            ->setEmail($userInfo->getEmail())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setParentId($userInfo->getParentId())
            ->setSoftDelete(false);

        $this->userRepository->save($createdUser, true);

        return $createdUser->getId();
    }

    /**
     * @inheritDoc
     */
    public function hasParent(int $parentId): void
    {
        if ($this->getUserById($parentId)->getParentId()) {
            throw new \Exception(_('Пользователь c parentId уже имеет родителя, привяжите другого!'));
        }
    }

    /**
     * @inheritDoc
     */
    public function editUser(UserUpdateDTO $userInfo, int $userId): int
    {
//        для случая если придется менять parentId
//        if($userId === $userInfo->getParentId()){
//            throw new \Exception(_('Вы не можете присвоить parentId равный id пользователя'));
//        }
//
//        if($userInfo->getParentId()){
//            $this->hasParent($userInfo->getParentId());
//        }

        $user = $this->getUserById($userId);

        $user
            ->setFirstName($userInfo->getFirstName())
            ->setLastName($userInfo->getLastName())
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->userRepository->save($user, true);

        return $user->getId();
    }

    /**
     * @inheritDoc
     */
    public function deleteUser(int $userId): void
    {
        $user = $this->getUserById($userId);

        $user
            ->setSoftDelete(true)
            ->setDeletedAt(new \DateTimeImmutable());

        $this->userRepository->save($user, true);
    }

}