<?php
require_once './vendor/autoload.php';
require_once './src/model/Liste.php';
require_once './src/model/Item.php';

use mywishlist\model\Item as Item;
use mywishlist\model\Liste as Liste;
use Illuminate\Database\Capsule\Manager as DB;

$db = new DB();
$db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'td9',
    'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
    'prefix'=>''] );
$db->setAsGlobal();
$db->bootEloquent();

// pour le select
if(isset($_GET["id"])){
    $id=$_GET["id"];
    $res=Liste::select("titre")->where("no","=",$id)->get();
    foreach ($res as $r){
        echo $r->titre."<br>";
    }
}