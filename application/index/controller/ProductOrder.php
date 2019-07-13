<?php
/**
 * Created by PhpStorm.
 * User: 86176
 * Date: 2019/6/28
 * Time: 13:59
 */

namespace app\index\controller;


use think\Db;
use think\Log;
use think\Request;
use app\index\util\DateUTil;
use think\Session;

class ProductOrder extends Common
{

    public function productOrder(){
        return $this->fetch("productOrder");
    }
    public function orderadd(Request $request){
        $result=false;
        $session=new Session();
        $dataUtil=new DateUTil();
        $data=$request->post()['params'];
        $c = $data['data'];
        $xs=[];
        foreach ($c as $k=>$v){
            if(preg_match('/\d/is', $v['name'])){
                $c[$k]['name']=explode("_",$v['name']);
                $k_num = explode('_', $v['name'])[1];
                //获取真正的name
                $k = explode(',', $v['name'])[0];
                if (strstr($v['name'], $k)) {
                    $save[$k_num][$k]             = $v;
                }
            }else{
                $xs[$v['name']]=$v;
            }
        }
            $data1['custom_id']=$xs['upcustom']['value'];
            $data1['status']=$xs['upstatus']['value'];
            $data1['countprice']=$xs['upcountprice']['value'];
            $data1['addresee']=$xs['upaddressee']['value'];
            $data1['city']=$xs['upcity']['value'];
            $data1['address']=$xs['upaddress']['value'];
            $data1['yxcode']=$xs['upcode']['value'];
            $data1['delivery']=$xs['updelivery']['value'];
            $data1['payment']=$xs['uppayment']['value'];
            $data1['create_time']=$dataUtil->getMillisecond()/1000;
            $data1['input_userid']=$session::get("userinfo")['id'];
            $data1['input_user']=$session::get("userinfo")['username'];
           $getid= Db::table("productorder")->insertGetId($data1);
            dump($getid);
            dump($save);
            $i=1;
            foreach ($save as $k2=>$v2){
                $data2['productid']=$v2['upproduct_'.$i]['value'];
                $data2['num']=$v2['upnumber_'.$i]['value'];
                $data2['price']=$v2['upprice_'.$i]['value'];
                $data2['countprice']=$v2['countss_'.$i]['value'];
                $data2['orderid']=$getid;
                $data2['create_time']=$dataUtil->getMillisecond()/1000;
                $i++;
                $result= Db::table("orderdetail")->insert($data2);
            }
            return $result?$this->success("添加成功!"):$this->error("添加失败!");
    }

    public function  orderlist(Request $request){
        $serachdata=$request->param();
        $order=new \app\index\model\productOrder();
//        $orderdata['list']=$order->paginate(12,true,['page'=>$serachdata['params']['page']]);
        $orderdata['list']= Db::table("productorder")->alias("a")->join('custom b',"a.custom_id=b.id")->paginate(12,true,['page'=>$serachdata['params']['page']]);
        return json($orderdata);
    }
}