<?php


namespace Budgetwise\Core;


use DI\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


class Router implements HttpKernelInterface
{
    protected RouteCollection $routes;
    protected Container $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->routes = new RouteCollection();
    }

    public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $attributes = $matcher->match($request->getPathInfo());
            $response = $this->triggerAction($attributes, $request);
        } catch (ResourceNotFoundException $exception) {
            $response = new Response('Not found!', Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    public function get($path, $controller): static
    {
        return $this->add(Request::METHOD_GET, $path, $controller);
    }

    public function post($path, $controller): static
    {
        return $this->add(Request::METHOD_POST, $path, $controller);
    }

    public function put($path, $controller): static
    {
        return $this->add(Request::METHOD_PUT, $path, $controller);
    }

    public function delete($path, $controller): static
    {
        return $this->add(Request::METHOD_DELETE, $path, $controller);
    }

    /**
     * @param $method
     * @param $path
     * @param $controller
     * @return $this
     *
     * Add a new route to route collection
     */
    public function add($method, $path, $controller): static
    {
        $route = $this->routes->get($path);

        if (!$route) {
            $route = new Route($path, [
                $method => $controller
            ]);

            $this->routes->add($path, $route);
        } else {
            $route->addDefaults([
                $method => $controller
            ]);
        }

        return $this;
    }

    /**
     * @param $attributes : Route attributes
     * @param $request : HTTP Request
     * @return Response
     *
     * Resolve the controller and get controller action
     */
    private function triggerAction($attributes, Request $request): Response
    {
        if (isset($attributes[$request->getMethod()])) {
            $controllerInfo = $attributes[$request->getMethod()];
            $attributes['request'] = $request;
            return $this->container->call($controllerInfo, $attributes);
        }
        throw new ResourceNotFoundException("Resource not found");
    }
}
