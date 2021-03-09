<?php

use fr\dieunelson\HeaderManager;
use fr\dieunelson\webservices\Request;
use fr\dieunelson\webservices\Response;
use fr\dieunelson\webservices\Route;
use fr\dieunelson\webservices\hello\Hello;
use fr\dieunelson\webservices\hello\HelloCtrl;
use fr\dieunelson\webservices\hello\HelloValidator;

Route::get("/hello/:variable", function (Request $req, Response $res)
{
  $hello = new Hello();
  $controller = new HelloCtrl();

  $view = $controller->hello($hello);

  $res->send($view->render());

}, new HelloValidator());

Route::get("/", function (Request $req, Response $res)
{
  HeaderManager::Location("./hello");
});