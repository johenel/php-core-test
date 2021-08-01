<?php 
namespace app\Services;

class Router 
{
    public static function get(string $path, string $controller, string $function): void
    {
        $GLOBALS['routes'][$path] = [
            'controller' => $controller,
            'function' => $function,
            'method' => 'get'
        ];
    }

    public function post() 
    {
        // not needed for the test
    }

    public function patch() 
    {
        // not needed for the test
    }

    public function put()
    {
        // not needed for the test
    }

    public function delete()
    {
        // not needed for the test
    }

    public function render(): void
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];

        if (
            isset($GLOBALS['routes'][$uri]) 
            && isset($GLOBALS['routes'][$uri]['method']) 
            && $GLOBALS['routes'][$uri]['method'] == strtolower($_SERVER['REQUEST_METHOD'])
        ) {
            include($GLOBALS['routes'][$uri]['controller'] . '.php');
            $controller = new $GLOBALS['routes'][$uri]['controller'];
            echo $controller->{$GLOBALS['routes'][$uri]['function']}();
        } else {
            echo "Page not found";
        }
    }
}