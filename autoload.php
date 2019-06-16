<?php

spl_autoload_register(function($class){
    $array = explode('\\',$class);
    //echo $class;
    if(count($array) > 1){
        $class_name = $array[count($array)-1];
        $array[count($array)-1] = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $class_name));
        $file_name = implode("/",$array);
    }else{
        $file_name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $class));
        
    }
    $file_name = preg_replace('/\\\\/', '/', $class);
    require_once "src/".$file_name.".php";
});
