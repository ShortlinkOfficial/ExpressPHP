<?php

namespace fr\dieunelson\webservices;

use Exception;

class Router {

    public function __construct() {}

    public function beforeRoute(Request $request, Response $response){}

    public function afterRoute(Request $request, Response $response){}

    public function route(string $url)
    {
        //  Recuperation des headers
        $requestHeaders = getallheaders();
        $requestType = $_SERVER['REQUEST_METHOD'];

        $route = Route::getInstance()->resolve($requestType, $url);
        
        $request = new Request($requestType,$requestHeaders, $url, $route["variables"], $_POST);
        $response = new Response();

        
        $this->beforeRoute($request, $response);

        if (!empty($route["validator"])) {
            if ($route["validator"]->validate($request)) {
                $route["callback"]($request, $response);
            }else{
                $exception = $route["validator"]->getException();
                if (empty($exception)) {
                    $exception = new Exception("Bad Request", 400);
                }
                
                throw $exception;
            }
        }else{
            $route["callback"]($request, $response);
        }
        
        
        $this->afterRoute($request, $response);

    }
}