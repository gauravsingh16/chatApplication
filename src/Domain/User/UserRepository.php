<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     */

    public function addUsername(string $username): bool;

    public function addGroupToUsername(string $username, string $group): bool;
    
    public function listAllGroups(): array;

    public function createGroup(string $username , string $group): bool;

    public function sendMessage(string $username, string $group, string $message): bool;

    public function viewChatList(string $group):array;

}
