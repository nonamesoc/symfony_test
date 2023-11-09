<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface UserServiceInterface
{

    /**
     * Create user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\Entity\User|\Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function createUser(Request $request): User|ConstraintViolationListInterface;

    /**
     * Get user list.
     *
     * @return array
     */
    public function getUsers(): array;

    /**
     * Get user by id.
     *
     * @param int $id
     *
     * @return \App\Entity\User|null
     */
    public function getUserById(int $id): ?User;

    /**
     * Delete user.
     *
     * @param \App\Entity\User $user
     *
     * @return void
     */
    public function deleteUser(User $user): void;

    /**
     * Update user.
     *
     * @param \App\Entity\User $user
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\Entity\User|null
     */
    public function updateUser(User $user, Request $request): User|ConstraintViolationListInterface;

}
