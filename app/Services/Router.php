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
        if (
            isset($GLOBALS['routes'][$_SERVER['REQUEST_URI']]) 
            && isset($GLOBALS['routes'][$_SERVER['REQUEST_URI']]['method']) 
            && $GLOBALS['routes'][$_SERVER['REQUEST_URI']]['method'] == strtolower($_SERVER['REQUEST_METHOD'])
        ) {
            include($GLOBALS['routes'][$_SERVER['REQUEST_URI']]['controller'] . '.php');
            $controller = new $GLOBALS['routes'][$_SERVER['REQUEST_URI']]['controller'];
            echo $controller->{$GLOBALS['routes'][$_SERVER['REQUEST_URI']]['function']}();
        } else {
            echo "Page not found";
        }
    }
}