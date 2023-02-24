<?php

namespace App\Services\UserService;

use App\DTO\UserDataDTO;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class UserService
 * @package App\Services\UserService
 */
class UserService implements UserServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
    )
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @inheritDoc
     */
    public function getUsersByPageAndLimit(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $usersArray = $this->entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->where('u.soft_delete = false')
            ->orderBy('u.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        if(!$usersArray){
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
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['id' => $id, 'soft_delete' => false]);
        if ($user === null) {
            throw new EntityNotFoundException(sprintf(_('Пользователь с id:%s не найден.'),$id));
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function createUser(UserDataDTO $userInfo): int
    {
        if($userInfo->getParentId()){
            $isParentExist = $this->getUserById($userInfo->getParentId());
            if($isParentExist){
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
        ->setSoftDelete(false);

         $this->entityManager->persist($createdUser);
         $this->entityManager->flush();

         return $createdUser->getId();
    }

    /**
     * @inheritDoc
     */
    public function hasParent(int $parentId): void
    {
        if($this->getUserById($parentId)->getParentId()){
            throw new \Exception(_('Пользователь c parentId уже имеет родителя, привяжите другого!'));
        }
    }

    /**
     * @inheritDoc
     */
    public function editUser(UserDataDTO $userInfo,int $userId): int
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

        $this->entityManager->getRepository(User::class)->save($user,true);

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

        $this->entityManager->getRepository(User::class)->save($user,true);

    }

}