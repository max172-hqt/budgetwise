<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Budgetwise\Core\Authenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionController extends AbstractController
{
    public function index(Request $request): Response
    {
        return $this->render('session/create.html.twig', [
            'heading' => 'Log In',
        ]);
    }

    /**
     * @param Request $request
     * @param Authenticator $authenticator
     * @return Response
     *
     * Log in
     */
    public function store(Request $request, Authenticator $authenticator): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $result = $authenticator->attempt($email, $password);

        if (false === $result) {
            return $this->render('session/create.html.twig', [
                'heading' => 'Sign Up',
                'email' => $email,
                'password' => $password,
                'errors' => [
                    'email' => 'Invalid email or password. Please try again.'
                ],
            ]);
        }

        return $this->redirect();
    }

    /**
     * @param Request $request
     * @param Authenticator $authenticator
     * @return Response
     *
     * Log out
     */
    public function destroy(Request $request, Authenticator $authenticator): Response
    {
        $authenticator->logout();
        return $this->redirect();
    }
}