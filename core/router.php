<?php

namespace Core;

/**
 * Router class
 */
class Router
{
    /**
     * Routing table
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Add a route to the routing table
     * @param string $route Route URL
     * @param array $params Parameters
     * @return void
     */
    public function add($route, $params = [])
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }

    /**
     * Get all routes from the routing table
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match route to routes in the routing tables
     * then update $params property if found.
     * @param string $url Route URL
     * @return boolean
     */
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Get the matched parameters
     * @return array
     */
    public function getParameters()
    {
        return $this->params;
    }

    /**
     * Dispatch the route to create controller object and run action method.
     * @param string $url Route URL
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToPascalCase($controller);
            $controller = $this->getNamespace() . $controller;
            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);
                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {
                    throw new \Exception("Method $action in controller $controller cannot be called directly. Remove the Action suffix to call this method.");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            throw new \Exception("No route matched", 404);
        }
    }

    /**
     * Convert string with hyphens to PascalCase
     * @param string $string String to be converted
     * @return string
     */
    protected function convertToPascalCase($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert string to camelCase
     * @param string $string String to be converted
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToPascalCase($string));
    }

    /**
     * Remove query from URL
     * @param string $url Original URL
     * @return string
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    /**
     * Get namespace of the controller class
     * @return string
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }

}

?>