<?php


namespace Budgetwise\Core;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


abstract class AbstractController
{
    protected Container $container;
    protected Request $request;

    public function __construct(Request $request) {
        $this->container = App::container();
        $this->request = $request;
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
        $parameters['pathInfo'] = $this->request->getPathInfo();
        $content = $this->renderView($view, $parameters);
        $response ??= new Response();
        $response->setContent($content);
        return $response;
    }
}