<?php


namespace app\index\model;


use think\Db;
use think\Model;

class User extends Model
{
    protected   $table='user';
    public function  getuserinfo($username){
        $result=$this->get(['username'=>$username]);
        return $result;
    }
}