<?php
namespace app\index\controller;

use think\Controller;
use think\Session;


class Index extends Common
{
    public function index()
    {
      return $this->fetch("index");
    }
}