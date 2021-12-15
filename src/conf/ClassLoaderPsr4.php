<?php

namespace mywishlist\conf;
class ClassLoaderPsr4{

    protected String $prefix,$dir;

    public function __construct(String $pre,String $d){
        $this->dir=$d;
        $this->prefix=$pre;
    }

    public function loadClass($classe){
        $classe =str_replace("\\","/",$classe);
        $tmp = str_replace("\\","/",$this->prefix);
        $classe =str_replace($tmp,"",$classe);
        $classe=$this->dir.$classe.".php";
        echo $classe."<br>";
        require_once $classe;
    }

    public function register(){
        spl_autoload_register([$this,'loadClass']);
    }
}