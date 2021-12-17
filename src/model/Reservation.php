<?php

namespace mywishlist\model;

class Reservation extends  \Illuminate\Database\Eloquent\Model {

    protected $table = 'reservation';
    protected $primaryKey = 'idReservation'; 
    public $timestamps = false;

    public function getItem(){
        return $this->belongsTo('mywishList\model\Item', 'idItem');
    }

    public function getList(){
        return $this->belongsTo('mywishList\model\Liste', 'idList');
    }
    

}