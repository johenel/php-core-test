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
            isset($GLOBALS['routes'][$_SERVER['REDIRECT_URL']]) 
            && isset($GLOBALS['routes'][$_SERVER['REDIRECT_URL']]['method']) 
            && $GLOBALS['routes'][$_SERVER['REDIRECT_URL']]['method'] == strtolower($_SERVER['REQUEST_METHOD'])
        ) {
            include($GLOBALS['routes'][$_SERVER['REDIRECT_URL']]['controller'] . '.php');
            $controller = new $GLOBALS['routes'][$_SERVER['REDIRECT_URL']]['controller'];
            echo $controller->{$GLOBALS['routes'][$_SERVER['REDIRECT_URL']]['function']}();
        } else {
            echo "Page not found";
        }
    }
}