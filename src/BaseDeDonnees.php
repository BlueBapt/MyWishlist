<?php

namespace mywishlist;
require_once "vendor/autoload.php";
use Exception;
use Illuminate\Database\Capsule\Manager as DB;

class BaseDeDonnees
{
    public static function getDB(): DB{
        try {
            $db = new DB();
            $db->addConnection(['driver' => 'mysql', 'host' => 'localhost', 'database' => 'td9',
                'username' => 'wishmaster', 'password' => 'TropFort54', 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci',
                'prefix' => '']);
            $db->setAsGlobal();
            $db->bootEloquent();
        }catch(Exception $e){
            echo $e;
        }
        return $db;
    }
}