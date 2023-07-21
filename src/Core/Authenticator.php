<?php

namespace Budgetwise\Core;

use Budgetwise\Entities\User;
use Symfony\Component\HttpFoundation\Session\Session;

class Authenticator
{
    protected array $errors = [];

    public function __construct(private readonly Database $db, private readonly Session $session)
    {
    }

    public function attempt($email, $password): bool
    {
        $user = $this->db->entityManager()->getRepository(User::class)->findOneBy([
            'email' => $email
        ]);

        if (!$user || !$user->isPasswordMatched($password)) {
            return false;
        }

        $this->login($user);
        return true;
    }

    public function exists($email): bool
    {
        return !!$this->db->entityManager()->getRepository(User::class)->findOneBy([
            'email' => $email
        ]);
    }

    public function login(User $user): void
    {
        $this->session->set('user', [
            'email' => $user->getEmail(),
            'name' => $user->getName()
        ]);
    }

    public function logout(): void
    {
        $this->session->invalidate();
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

}