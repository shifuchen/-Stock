<?php
/**
 * Created by PhpStorm.
 * User: 86176
 * Date: 2019/6/28
 * Time: 13:59
 */

namespace app\index\controller;


use think\Log;
use think\Request;

class ProductOrder extends Common
{
    public function productOrder(){
        return $this->fetch("productOrder");
    }
    public function orderadd(Request $request){
       $data=$request->post()['params'];
       Log::error($data);
    }

}