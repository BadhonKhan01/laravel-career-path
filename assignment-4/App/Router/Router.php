<?php 
namespace App\Router;
require_once __DIR__.'/routes.php';

class Router
{
    private static $list = [];

    public static function get(string $page, array $action){
        static::$list[] = [
            'page' => $page,
            'method' => 'GET',
            'action' => [
                'controller' => $action[0],
                'method' => $action[1]
            ]
        ];
    }

    public static function post(string $page, array $action){
        static::$list[] = [
            'page' => $page,
            'method' => 'POST',
            'action' => [
                'controller' => $action[0],
                'method' => $action[1]
            ]
        ];
    }

    public static function dispatch(){

        $method = $_SERVER['REQUEST_METHOD'];
        $page = parse_url($_SERVER['REQUEST_URI'])['path'];
        $queryParameters = $_GET;

        foreach (static::$list as $item) {
            if($item['page'] === $page && $item['method'] === $method){
                $controller = new $item['action']['controller']();
                if(!empty($queryParameters)){
                    $controller->{$item['action']['method']}($queryParameters);
                }else{
                    $controller->{$item['action']['method']}();
                }
                
            }
        }
    }
}
