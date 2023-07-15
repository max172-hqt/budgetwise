<?php


namespace Budgetwise\Core;


use Symfony\Component\HttpFoundation\Response;


abstract class AbstractController
{
    protected Container $container;

    public function __construct() {
        $this->container = App::container();
    }

    protected function container(): Container
    {
        return $this->container;
    }

    protected function renderView(string $view, array $parameters = []): string
    {
        $twig = $this->container->resolve('twig');
        return $twig->render($view, $parameters);
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response {
        $content = $this->renderView($view, $parameters);
        $response ??= new Response();
        $response->setContent($content);
        return $response;
    }
}