<?php

require_once  '../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;

$db = new DB();
$db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'td9',
    'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
    'prefix'=>''] );
$db->setAsGlobal();
$db->bootEloquent();

echo "connecté";