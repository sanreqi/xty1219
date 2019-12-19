<?php
/**
 * Created by PhpStorm.
 * User: srq
 * Date: 2019/2/14
 * Time: 11:51
 */

namespace frontend\models;



class Student
{
    public $id;
    public $name;

    public function __construct($id, $name="xxx", Bag $bag)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bag = $bag;
    }
    public function study()
    {
        echo $this->name.' is learning.....'.PHP_EOL;
    }

    public function showBag(){
        echo "My bag is ".$this->bag->name();
    }
}
