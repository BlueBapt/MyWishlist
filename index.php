<?php
require_once './vendor/autoload.php';
require_once './src/models/Liste.php';
require_once './src/models/Item.php';

use mywishlist\models\Item as Item;
use mywishlist\models\Liste as Liste;
use Illuminate\Database\Capsule\Manager as DB;

$db = new DB();
$db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'td9',
    'username'=>'luigi','password'=>'mamamia','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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

//pour inserer
/**
$nl = new Liste();
$nl->no=4;
$nl->titre="nouvelle entree";
$nl->description="description";
$nl->save();
$res=Liste::select("titre")->where("no","=",4)->get();
foreach ($res as $r){
    echo $r->titre."<br>";
}
*/

// pour faire le lien
$res=Item::select("id","nom","descr","liste_id")->get();
//echo $res->nom.",".$res->descr.",".$res->liste()->first()->titre."<br>";
foreach ($res as $r){
    if($r->liste()->first()!=null){
        echo $r->nom.",".$r->descr.",".$r->liste()->first()->titre."<br>";
    }else{
        echo $r->nom.",".$r->descr."<br>";
    }


}


