<?php

namespace App\Services\UserService;

use App\DTO\UserDataDTO;
use App\Entity\User;

/**
 * Interface UserServiceInterface
 * @package App\Services\UserService
 */
interface UserServiceInterface
{
    /**
     * Получить пользователей по странице и лимиту
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getUsersByPageAndLimit(int $page, int $limit): array;

    /**
     * Получить пользователя по идентификатору
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User;


    /**
     * Получить пользователя по идентификатору
     * @param UserDataDTO $userInfo
     * @return int
     */
    public function createUser(UserDataDTO $userInfo): int;

    /**
     * Отредактировать пользователя по идентификатору
     * @param UserDataDTO $userInfo
     * @param int $userId
     * @return int
     */
    public function editUser(UserDataDTO $userInfo, int $userId): int;

    /**
     * Проверяет есть ли у родителя родитель
     * @param int $parentId
     * @return void
     */
    public function hasParent(int $parentId): void;

    /**
     * Удалить пользователя по идентификатору
     * @param int $userId
     * @return void
     */
    public function deleteUser(int $userId): void;
}