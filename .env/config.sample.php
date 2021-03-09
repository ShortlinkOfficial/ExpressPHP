<?php

define('PRODUCTION', true);

if(PRODUCTION){
    define('WEB_ROOT', '/');
}else{
    require_once 'config.dev.php';
}
