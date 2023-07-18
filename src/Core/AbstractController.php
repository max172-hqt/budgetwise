<?php


namespace Budgetwise\Core;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


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

    protected function renderView(string $view, array $parameters = []): string
    {
        return $this->twig->render($view, $parameters);
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $parameters['pathInfo'] = $this->request->getPathInfo();
        $parameters['isLoggedIn'] = (bool)$this->request->getSession()->get('users');
        $parameters['user'] = $this->request->getSession()->get('users') ?? null;

        $content = $this->renderView($view, $parameters);
        $response ??= new Response();
        $response->setContent($content);
        return $response;
    }

    protected function redirect($path = '/'): RedirectResponse
    {
        return new RedirectResponse('/');
    }
}
