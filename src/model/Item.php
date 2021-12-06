<?php

namespace mywishlist\model;

class Item extends \Illuminate\Database\Eloquent\Model {
    
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste() {
        return $this->hasMany('mywishlist\model\Liste', 'liste_id');
    }
}

















?>