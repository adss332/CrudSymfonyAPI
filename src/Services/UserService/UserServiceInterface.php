<?php

namespace App\Services\UserService;

use App\DTO\UserCreateDTO;
use App\DTO\UserUpdateDTO;
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
     * Создать пользователя
     * @param UserCreateDTO $userInfo
     * @return int
     */
    public function createUser(UserCreateDTO $userInfo): int;

    /**
     * Отредактировать пользователя по идентификатору
     * @param UserUpdateDTO $userInfo
     * @param int $userId
     * @return int
     */
    public function editUser(UserUpdateDTO $userInfo, int $userId): int;

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