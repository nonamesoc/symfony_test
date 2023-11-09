<?php

namespace App\Controller;

use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/user')]
class UserController extends AbstractController
{

    /**
     * Create class.
     *
     * @param \App\Service\UserServiceInterface $userService
     */
    public function __construct(private UserServiceInterface $userService)
    {
    }

    /**
     * Get user list.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/', name: 'user_list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $users = $this->userService->getUsers();
        return $this->json(['users' => $users]);
    }

    /**
     * Create user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/', name: 'create_user', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $result = $this->userService->createUser($request);
        if ($result instanceof ConstraintViolationListInterface) {
            return $this->json(['errors' => $result]);
        }

        return $this->json(['message' => 'User created successfully', 'id' => $result->getId()]);
    }

    /**
     * Get user by id.
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/{id}', name: 'show_user', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        if (empty($user)) {
            return $this->json(['message' => 'User not found'], 404);
        }

        return $this->json($user);
    }

    /**
     * Update user.
     *
     * @param int $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/{id}', name: 'edit_user', methods: ['PUT'])]
    public function edit(int $id, Request $request): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        if (empty($user)) {
            return $this->json(['message' => 'User not found'], 404);
        }

        $result = $this->userService->updateUser($user, $request);
        if ($result instanceof ConstraintViolationListInterface) {
            return $this->json(['errors' => $result]);
        }

        return $this->json(['message' => 'User updated', 'user' => $result]);
    }

    /**
     * Delete user.
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        if (empty($user)) {
            return $this->json(['message' => 'User not found'], 404);
        }

        $this->userService->deleteUser($user);
        return $this->json(['message' => 'User deleted']);
    }

}
