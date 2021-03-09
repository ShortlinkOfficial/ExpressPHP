<?php

$root = realpath(dirname(__FILE__));

require_once "$root/fr/dieunelson/webservices/RequestValidator.class.php";
require_once "$root/fr/dieunelson/webservices/Request.class.php";
require_once "$root/fr/dieunelson/webservices/Response.class.php";
require_once "$root/fr/dieunelson/webservices/Route.class.php";
require_once "$root/fr/dieunelson/webservices/Router.class.php";
require_once "$root/fr/dieunelson/webservices/View.class.php";
require_once "$root/fr/dieunelson/DB.class.php";
require_once "$root/fr/dieunelson/Cleanable.interface.php";
require_once "$root/fr/dieunelson/Repository.interface.php";
require_once "$root/fr/dieunelson/HeaderManager.class.php";
require_once "$root/fr/dieunelson/CleanableRepository.interface.php";