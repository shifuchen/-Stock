<?php


namespace app\index\controller;
use think\Controller;
use think\Session;

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

    public function getsession(){
        return session("userinfo");
    }
    public function logout(){
        return Session::delete("userinfo");
    }

}