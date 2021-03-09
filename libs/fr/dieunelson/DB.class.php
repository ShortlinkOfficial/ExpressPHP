<?php

namespace fr\dieunelson\webservices;

use PDO;

class DB{

    private static $pdo;

    public static function getInstance($host=null, $port=null, $name=null, $user=null, $pass=null) : \PDO
    {
        if(!DB::$pdo){
            try {
                if($host && $port && $name && $user && $pass){
                    DB::$pdo = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$name,
                    $user,
                    $pass) or die;
                }else{
                    DB::$pdo = new PDO('mysql:host='.AUTH_DB_HOST.';port='.AUTH_DB_PORT.';dbname='.AUTH_DB_NAME,
                    AUTH_DB_USER,
                    AUTH_DB_PASS);
                }
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage(),500);
            }
        }

        return DB::$pdo;

    }
}