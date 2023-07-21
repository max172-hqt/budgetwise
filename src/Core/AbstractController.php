<?php

namespace Budgetwise\Core;

use Budgetwise\Entities\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class AbstractController
{
    protected Environment $twig;
    protected Database $db;
    protected Request $request;

    public function __construct(Environment $twig, Database $db, Request $request)
    {
        $this->twig = $twig;
        $this->db = $db;
        $this->request = $request;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function renderView(string $view, array $parameters = []): string
    {
        return $this->twig->render($view, $parameters);
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $parameters['pathInfo'] = $this->request->getPathInfo();
        $parameters['isLoggedIn'] = (bool)$this->request->getSession()->get('user');
        $parameters['currentUser'] = $this->request->getSession()->get('user') ?? null;

        $content = $this->renderView($view, $parameters);
        $response ??= new Response();
        $response->setContent($content);
        return $response;
    }

    protected function redirect($path = '/'): RedirectResponse
    {
        return new RedirectResponse($path);
    }

    protected function entityManager(): EntityManager
    {
        return $this->db->entityManager();
    }

    protected function getCurrentUser(): ?User {
        $user = $this->request->getSession()->get('user');

        if (!$user) {
            return null;
        }

        $dbUser = $this->entityManager()->getRepository(User::class)->findOneBy([
            'email' => $user['email']
        ]);

        return $dbUser;
    }
}
