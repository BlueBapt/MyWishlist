<?php

namespace mywishlist\model;

class Liste extends \Illuminate\Database\Eloquent\Model {
    
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function item() {
        return $this->belongsTo('mywishlist\model\Liste', 'liste_id');
    }

    public function message() {
        return $this->belongsTo('mywishlist\model\Liste', 'no');
    }
    
    public function affichageDetail() {
       $q1 = liste::select('no','user_id','titre','description','expiration','token');
       $q2 = item::select('id','liste_id','nom','descr','img','url','tarif');
    }

    public function cookie($date){
        setcookie("EtatReservation","valeur", time() +$date,"mywishlist\model");
        if( isset( $_COOKIE["EtatReservation"])) {
            $track_user_code = $_COOKIE['EtatReservation'];
        }
    }



}

















?>