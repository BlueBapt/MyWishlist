<?php

namespace ProjetWishlist\model;

class Liste extends \Illuminate\Database\Eloquent\Model {
    
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function item() {
        return $this->belongsTo('ProjetWishlist\modele\Liste', 'liste_id');
    }

    public function message() {
        return $this->belongsTo('ProjetWishlist\modele\Liste', 'no');
    }
    
    public function affichageDetail() {
       $q1 = liste::select('no','user_id','titre','description','expiration','token');
       $q2 = item::select('id','liste_id','nom','descr','img','url','tarif');
    }

    public function cookie($date){
        setcookie("EtatReservation","valeur", time() +$date,"EXO/ProjetWishlist/model");
        if( isset( $_COOKIE["EtatReservation"])) {
            $track_user_code = $_COOKIE['EtatReservation'];
        }
    }



}

















?>