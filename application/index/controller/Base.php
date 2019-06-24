<?php


namespace app\index\controller;


use think\Controller;

class Base extends Common
{
    public  function  base(){
        return $this->fetch('base');
    }
}