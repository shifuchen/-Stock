<?php


namespace app\index\controller;
use think\Controller;
use think\Log;
use think\Request;
use think\Session;

class Login extends Controller
{
    public  function  index(){
        return $this->fetch("login");
    }

    public function login(Request $request){
        $userinfo=$request->post()['params'];
        $result="";
       if($userinfo){
            $usercon=new \app\index\model\User();
             $userdata=  $usercon->getuserinfo($userinfo['username']);
             Log::error($userdata);
             if($userdata){
                if($userinfo['username']==$userdata['username']){
                    if(md5($userinfo['password'])==$userdata['password']){
                        unset($userdata['password']);
                        $session=new Session();
                        $session::set('userinfo',$userdata);
                        $result=json(['msg'=>'登录成功','returncode'=>200]);
                    }else{
                        $result=json(['msg'=>'密码不正确','returncode'=>20010]);
                    }
                }else{
                    $result=json(['msg'=>'用户名不正确','returncode'=>20012]);
                }
             }else{
                 $result=json(['msg'=>'用户不存在或已删除','returncode'=>20013]);
             }
       }
       Log::error($result);
        return $result;
    }


}