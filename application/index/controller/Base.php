<?php


namespace app\index\controller;


use think\Controller;

class Base extends Controller
{
    public  function  base(){
        return $this->fetch('base');
    }
}