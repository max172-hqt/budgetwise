<?php


namespace Budgetwise\Core;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


abstract class AbstractController
{
    protected Environment $twig;
    protected Database $db;

    public function __construct(Environment $twig, Database $db) {
        $this->twig = $twig;
        $this->db = $db;
    }

    protected function renderView(string $view, array $parameters = []): string
    {
        return $this->twig->render($view, $parameters);
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response {
        $parameters['pathInfo'] = get_path($_SERVER['REQUEST_URI']);
        $content = $this->renderView($view, $parameters);
        $response ??= new Response();
        $response->setContent($content);
        return $response;
    }
}