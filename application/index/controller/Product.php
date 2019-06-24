<?php


namespace app\index\controller;


use think\Controller;

class Product extends Common
{
    public function  index(){
        return $this->fetch("productmanger");
    }
}