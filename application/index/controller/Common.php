<?php


namespace app\index\controller;
use think\Controller;

class Common extends Controller
{
    /**
     * 判断登录
     */
    public  function  _initialize()
    {
        if(!session('userinfo')){
            $this->error('您还未登录系统,请登录!',url("/index/login/index"));
        }
    }

}