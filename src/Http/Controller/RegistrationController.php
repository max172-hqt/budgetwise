<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Budgetwise\Core\Authenticator;
use Budgetwise\Core\Database;
use Budgetwise\Entities\User;
use Budgetwise\Http\Forms\RegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class RegistrationController extends AbstractController
{
    private readonly Authenticator $authenticator;

    public function __construct(Environment $twig, Database $db, Request $request, Authenticator $authenticator)
    {
        parent::__construct($twig, $db, $request);
        $this->authenticator = $authenticator;
    }

    public function index(): Response
    {
        return $this->render('registration/create.html.twig', [
            'heading' => 'Sign Up',
        ]);
    }

    public function store(Request $request): Response
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

        $existed = $this->authenticator->exists($email, $password);

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
        $this->authenticator->attempt($email, $password);

        return $this->redirect();
    }
}