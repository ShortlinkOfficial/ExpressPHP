<?php

namespace fr\dieunelson\webservices;

use Exception;

class Route{
  
  private static $instance;
  private $routes;

  private function __construct()
  {
    $this->routes = [
      "GET" => [],
      "POST" => [],
      "PUT" => [],
      "DELETE" => []
    ];
  }

  public static function getInstance() : Route
  {
    if(empty(Route::$instance)){
      Route::$instance = new Route();
    }
    return Route::$instance;
  }

  public static function get($path, $callback, RequestValidator $validator = null)
  {
    Route::getInstance()->addRoute("GET", $path, $callback, $validator);
  }

  public static function post($path, $callback, RequestValidator $validator = null)
  {
    Route::getInstance()->addRoute("POST", $path, $callback, $validator);
  }

  public static function put($path, $callback, RequestValidator $validator = null)
  {
    Route::getInstance()->addRoute("PUT", $path, $callback, $validator);
  }

  public static function delete($path, $callback, RequestValidator $validator = null)
  {
    Route::getInstance()->addRoute("DELETE", $path, $callback, $validator);
  }

  public function resolve($protocole, $path)
  {

    $find = false;
    $route = null;
    foreach ($this->routes[$protocole] as $key => $value) {
      if (is_array($value["pattern"])){
        foreach ($value["pattern"] as $pattern) {
          if (preg_match($pattern, $path)) {
            $route = $value;
            $find = true;
            break;
          }
        }
        if ($find){break;}
      }else if (preg_match($value["pattern"], $path)) {
        $route = $value;
        $find = true;
        break;
      }      
    }

    if (array_key_exists($protocole, $this->routes) && $find)
    {
      $path_tab = explode("/", $path);
      $variables = [];

      foreach ($route["variables"] as $variable) {
        if (array_key_exists($variable["index"], $path_tab)){
          $variables[$variable["name"]] = $path_tab[$variable["index"]];
        }else{
          $variables[$variable["name"]] = null;
        }
        
      }

      return [
        "variables" => $variables,
        "callback" => $route["callback"],
        "validator" => $route["validator"]
      ];
    }
    throw new Exception("Route [$protocole] $path not exists", 404);
  }

  public function addRoute($protocole, $path, $callback, RequestValidator $validator = null)
  {
    if (array_key_exists($protocole, $this->routes))
    {      
      $path_tab = explode("/", $path);

      $pattern_tab = [];
      $variables = [];
      $lenth = count($path_tab);
      $lastIsVar = false;
      for ($index=0; $index < $lenth; $index++) {
        $section = $path_tab[$index];
        if (strpos($section, ":")===0) {
          $variables[] = [
            "name" => substr($section, 1),
            "index" => $index
          ];
          $pattern_tab[] = "([A-Za-z0-9]*)";
          if ($index === $lenth-1){
            $lastIsVar = true;
          }
        }else{          
          $pattern_tab[] = $section;
        }
      }

      if ($lastIsVar) {
        $pattern = [];
        $pattern[] = "/^".implode("\/", $pattern_tab)."$/";
        $slice = array_slice($pattern_tab, 0, $lenth-1);
        $pattern[] = "/^".implode("\/", $slice)."$/";
      } else {
        $pattern = "/^".implode("\/", $pattern_tab)."$/";
      }

      $this->routes[$protocole][$path] = [
        "pattern" => $pattern,
        "variables" => $variables,
        "callback" => $callback,
        "validator" => $validator
      ];
    }else{
      throw new Exception("Protocole $protocole not exists",500);
    }
    
  }



}