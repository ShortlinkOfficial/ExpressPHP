<?php

namespace fr\dieunelson\webservices\hello;

use fr\dieunelson\webservices\View;

class HelloCtrl{

    public function __construct(){}

    public function hello(Hello $hello): View
    {
        $view_path = realpath(dirname(__FILE__)."/../views/hello.view.html");
        $assets_path = WEB_ROOT."/assets";
        $view = new View($view_path);
        $view->bind($hello->data());
        $view->bind([
            "assets" => $assets_path
        ]);
        return $view;
    }
}