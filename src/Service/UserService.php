<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService implements UserServiceInterface
{

    /**
     * Create class.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(private EntityManagerInterface $entityManager,
                                private ValidatorInterface $validator)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function createUser(Request $request): User|ConstraintViolationListInterface
    {
        $fields = ['email', 'name', 'age', 'sex', 'birthday', 'phone'];
        $input = [];
        foreach ($fields as $field) {
            $input[$field] = !empty($request->get($field)) ? $request->get($field) : null;
        }

        $user = new User();
        $user->setEmail($input['email'])
            ->setName($input['name'])
            ->setAge($input['age'])
            ->setSex($input['sex'])
            ->setBirthday($input['birthday'])
            ->setPhone($input['phone']);

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return $errors;
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function getUserById(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteUser(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function updateUser(User $user, Request $request): User|ConstraintViolationListInterface
    {
        $fields = [
            'email' => 'setEmail',
            'name' => 'setName',
            'age' => 'setAge',
            'sex' => 'setSex',
            'birthday' => 'setBirthday',
            'phone' => 'setPhone'
        ];
        $input = $request->request->all();
        foreach ($input as $field => $value) {
            if (key_exists($field, $fields)) {
                $method = $fields[$field];
                $user->{$method}($value);
            }
        }

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return $errors;
        }

        $this->entityManager->flush();
        return $user;
    }

}
