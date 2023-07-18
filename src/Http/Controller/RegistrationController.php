<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Budgetwise\Core\Authenticator;
use Budgetwise\Entities\User;
use Budgetwise\Http\Forms\RegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('registration/create.html.twig', [
            'heading' => 'Sign Up',
        ]);
    }

    public function store(Request $request, Authenticator $authenticator): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $form = new RegistrationForm($email, $password);

        if (!$form->isValid()) {
            return $this->render('registration/create.html.twig', [
                'heading' => 'Sign Up',
                'email' => $email,
                'password' => $password,
                'errors' => $form->getErrors(),
            ]);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);

        $existed = $authenticator->exists($email, $password);

        if ($existed) {
            $form->setErrors('email', 'Email is already registered. Please try again.');
            return $this->render('registration/create.html.twig', [
                'heading' => 'Sign Up',
                'email' => $email,
                'password' => $password,
                'errors' => $form->getErrors(),
            ]);
        }

        $this->db->persistAndFlush($user);
        $authenticator->attempt($email, $password);

        return $this->redirect();
    }
}