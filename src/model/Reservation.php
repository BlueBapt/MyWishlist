<?php

namespace mywishlist\model;

class Reservation extends  \Illuminate\Database\Eloquent\Model {

    protected $table = 'reservation';
    protected $primaryKey = 'idItem'; 
    public $timestamps = false;

    public function reservation(){
        return $this->Hasmany('\mywishlist\model\Reservation', 'idItem');
    }

}