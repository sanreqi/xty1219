<?php
/**
 * Created by PhpStorm.
 * User: srq
 * Date: 2019/2/14
 * Time: 11:58
 */

namespace frontend\models;


class Bag{

    public $name;

    public function __construct($name){
        $this->name = $name;
    }

    public function name(){
        return  "学生包--".$this->name.PHP_EOL;
    }
}
